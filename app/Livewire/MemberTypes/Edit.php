<?php

namespace App\Livewire\MemberTypes;

use App\Enums\MemberPaymentStatus;
use App\Enums\MemberPeriodicity;
use App\Models\MemberType;
use App\Models\Season;
use DOMDocument;
use Illuminate\Http\UploadedFile;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Edit extends Component
{
    use WithFileUploads;

    public MemberType $memberType;

    public string $name = '';
    public string $description = '';
    public string $price = '';
    public string $periodicity = '';
    
    // 1. Propiedad para el nuevo archivo (sin tipar como string)
    public $card_template; 
    
    // 2. Propiedad opcional para conservar o mostrar la imagen actual
    public ?string $existing_card_template = null; 

    public bool $active = true;
    public string $season_id = '';
    public bool $bank_account = false;
    public bool $credit_card = false;

    public function mount(MemberType $memberType): void
    {
        $memberType->load('memberSeasons.member'); // Cargamos la relación 'memberSeasons' y a su vez la relación 'memberSeasons.member' para evitar consultas adicionales
        // dd($memberType->memberSeasons); // Puedes descomentar esta línea para depuración si es necesario

        $this->memberType               = $memberType;
        $this->name                     = $memberType->name;
        $this->description              = $memberType->description ?? '';
        $this->price                    = $memberType->price;
        $this->periodicity              = $memberType->periodicity instanceof MemberPeriodicity
            ? $memberType->periodicity->value
            : $memberType->periodicity;
        
        // Asignamos la ruta previa a la propiedad de lectura
        $this->existing_card_template   = $memberType->card_template; 
        
        $this->active                   = $memberType->active;
        $this->bank_account             = $memberType->bank_account;
        $this->credit_card              = $memberType->credit_card;
        $this->season_id                = $memberType->season_id;
    }



    protected function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string|max:1000',
            'price'         => 'required|numeric|min:0',
            'periodicity'   => 'required|in:' . implode(',', array_column(MemberPeriodicity::cases(), 'value')),
            'season_id'     => 'required|exists:seasons,id',
            'active'        => 'boolean',
            'card_template' => 'nullable|image|max:2048', // Valida solo si se sube un nuevo archivo
        ];
    }

    protected $messages = [
        'name.required'        => 'El nombre es obligatorio.',
        'price.required'       => 'El precio es obligatorio.',
        'periodicity.required' => 'La periodicidad es obligatoria.',
        'season_id.required'   => 'La temporada es obligatoria.',
        'active.boolean'       => 'El campo activo debe ser verdadero o falso.',
        'card_template.image'  => 'El archivo debe ser una imagen.',
        'card_template.max'    => 'La imagen no debe superar los 2MB.',
    ];

    public function updatedPrice(string $value): void
    {
        $this->price = str_replace(',', '.', $value);
    }

    public function downloadRemesaXml(): StreamedResponse
    {
        // $school = currentSchool();
        $school = auth()->user()->sportsSchool; // Obtenemos el club del usuario autenticado

        if (!$school || empty($school->bank_account) || empty($school->nif)) {
            session()->flash('error', 'El club no tiene NIF o cuenta bancaria (IBAN) configurados. Complete estos datos antes de generar la remesa.');
            abort(400, 'Faltan datos bancarios del club (NIF / IBAN).');
        }

        $memberType = $this->memberType->loadMissing('memberSeasons.member');

        // Recibos pendientes con IBAN y mandato SEPA vlidos
        $seasons = $memberType->memberSeasons->filter(function ($ms) {
            return $ms->payment_status === MemberPaymentStatus::Pending
                && $ms->member
                && !empty($ms->member->bank_account)
                && !empty($ms->member->sepa_mandate_ref);
        })->values();

        if ($seasons->isEmpty()) {
            session()->flash('error', 'No hay recibos pendientes con IBAN y mandato SEPA asignados para remesar.');
            abort(400, 'No hay recibos pendientes con IBAN asignado para remesar.');
        }

        $totalAmount   = (float) $seasons->sum(fn ($ms) => (float) $ms->price);
        $txCount       = $seasons->count();
        $msgId         = 'REM-' . date('YmdHis');
        $executionDate = now()->addDays(3)->format('Y-m-d');

        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;

        $document = $xml->createElement('Document');
        $document->setAttribute('xmlns', 'urn:iso:std:iso:20022:tech:xsd:pain.008.001.02');
        $document->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $xml->appendChild($document);

        $cstmrDrctDbtInitn = $xml->createElement('CstmrDrctDbtInitn');
        $document->appendChild($cstmrDrctDbtInitn);

        // Cabecera del Grupo (GrpHdr)
        $grpHdr = $xml->createElement('GrpHdr');
        $grpHdr->appendChild($xml->createElement('MsgId', $msgId));
        $grpHdr->appendChild($xml->createElement('CreDtTm', date('Y-m-d\TH:i:s')));
        $grpHdr->appendChild($xml->createElement('NbOfTxs', (string) $txCount));
        $grpHdr->appendChild($xml->createElement('CtrlSum', number_format($totalAmount, 2, '.', '')));

        $initgPty = $xml->createElement('InitgPty');
        $initgPty->appendChild($xml->createElement('Nm', mb_substr($school->name, 0, 70)));
        $grpHdr->appendChild($initgPty);
        $cstmrDrctDbtInitn->appendChild($grpHdr);

        // Informacion del Pago (PmtInf)
        $pmtInf = $xml->createElement('PmtInf');
        $pmtInf->appendChild($xml->createElement('PmtInfId', 'PMT-' . $msgId));
        $pmtInf->appendChild($xml->createElement('PmtMtd', 'DD'));
        $pmtInf->appendChild($xml->createElement('NbOfTxs', (string) $txCount));
        $pmtInf->appendChild($xml->createElement('CtrlSum', number_format($totalAmount, 2, '.', '')));

        $pmtTpInf = $xml->createElement('PmtTpInf');
        $svcLvl   = $xml->createElement('SvcLvl');
        $svcLvl->appendChild($xml->createElement('Cd', 'SEPA'));
        $pmtTpInf->appendChild($svcLvl);

        $lclInstrm = $xml->createElement('LclInstrm');
        $lclInstrm->appendChild($xml->createElement('Cd', 'CORE'));
        $pmtTpInf->appendChild($lclInstrm);
        $pmtTpInf->appendChild($xml->createElement('SeqTp', 'RCUR'));
        $pmtInf->appendChild($pmtTpInf);

        $pmtInf->appendChild($xml->createElement('ReqdColltnDt', $executionDate));

        // Datos del Acreedor (Club)
        $cdtr = $xml->createElement('Cdtr');
        $cdtr->appendChild($xml->createElement('Nm', mb_substr($school->name, 0, 70)));
        $pmtInf->appendChild($cdtr);

        $cdtrAcct = $xml->createElement('CdtrAcct');
        $id = $xml->createElement('Id');
        $id->appendChild($xml->createElement('IBAN', str_replace(' ', '', $school->bank_account)));
        $cdtrAcct->appendChild($id);
        $pmtInf->appendChild($cdtrAcct);

        $cdtrAgt = $xml->createElement('CdtrAgt');
        $finInstnId = $xml->createElement('FinInstnId');
        $othr = $xml->createElement('Othr');
        $othr->appendChild($xml->createElement('Id', 'NOTPROVIDED'));
        $finInstnId->appendChild($othr);
        $cdtrAgt->appendChild($finInstnId);
        $pmtInf->appendChild($cdtrAgt);

        // Identificador de Acreedor SEPA (ES + 2 dg control + sufijo 000 + NIF)
        $cdtrSchmeId = $xml->createElement('CdtrSchmeId');
        $idSchme  = $xml->createElement('Id');
        $prvtId   = $xml->createElement('PrvtId');
        $othrSchme = $xml->createElement('Othr');
        $othrSchme->appendChild($xml->createElement('Id', $this->buildSpanishCreditorId($school->nif)));
        $schmeNm = $xml->createElement('SchmeNm');
        $schmeNm->appendChild($xml->createElement('Prtry', 'SEPA'));
        $othrSchme->appendChild($schmeNm);
        $prvtId->appendChild($othrSchme);
        $idSchme->appendChild($prvtId);
        $cdtrSchmeId->appendChild($idSchme);
        $pmtInf->appendChild($cdtrSchmeId);

        foreach ($seasons as $ms) {
            $member = $ms->member;
            $drctDbtTxInf = $xml->createElement('DrctDbtTxInf');

            $pmtId = $xml->createElement('PmtId');
            $pmtId->appendChild($xml->createElement('EndToEndId', 'REC-' . $ms->id . '-' . date('Ymd')));
            $drctDbtTxInf->appendChild($pmtId);

            $instdAmt = $xml->createElement('InstdAmt', number_format((float) $ms->price, 2, '.', ''));
            $instdAmt->setAttribute('Ccy', 'EUR');
            $drctDbtTxInf->appendChild($instdAmt);

            $drctDbtTx = $xml->createElement('DrctDbtTx');
            $mndtRltdInf = $xml->createElement('MndtRltdInf');
            $mndtRltdInf->appendChild($xml->createElement('MndtId', $member->sepa_mandate_ref));
            $mndtRltdInf->appendChild($xml->createElement(
                'DtOfSgntr',
                $member->sepa_mandate_date
                    ? $member->sepa_mandate_date->format('Y-m-d')
                    : date('Y-m-d')
            ));
            $drctDbtTx->appendChild($mndtRltdInf);
            $drctDbtTxInf->appendChild($drctDbtTx);

            $dbtrAgt = $xml->createElement('DbtrAgt');
            $finInstnIdDbtr = $xml->createElement('FinInstnId');
            $othrDbtr = $xml->createElement('Othr');
            $othrDbtr->appendChild($xml->createElement('Id', 'NOTPROVIDED'));
            $finInstnIdDbtr->appendChild($othrDbtr);
            $dbtrAgt->appendChild($finInstnIdDbtr);
            $drctDbtTxInf->appendChild($dbtrAgt);

            $dbtr = $xml->createElement('Dbtr');
            $holder = $member->bank_account_holder ?: trim(($member->name ?? '') . ' ' . ($member->surname ?? ''));
            $dbtr->appendChild($xml->createElement('Nm', mb_substr($holder, 0, 70)));
            $drctDbtTxInf->appendChild($dbtr);

            $dbtrAcct = $xml->createElement('DbtrAcct');
            $idDbtr = $xml->createElement('Id');
            $idDbtr->appendChild($xml->createElement('IBAN', str_replace(' ', '', $member->bank_account)));
            $dbtrAcct->appendChild($idDbtr);
            $drctDbtTxInf->appendChild($dbtrAcct);

            $rmtInf = $xml->createElement('RmtInf');
            $rmtInf->appendChild($xml->createElement('Ustrd', 'Cuota ' . mb_substr($memberType->name, 0, 120)));
            $drctDbtTxInf->appendChild($rmtInf);

            $pmtInf->appendChild($drctDbtTxInf);
        }

        $cstmrDrctDbtInitn->appendChild($pmtInf);

        $fileName = 'remesa_sepa_' . date('Y-m-d_H-i') . '.xml';
        $content  = $xml->saveXML();

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, $fileName, [
            'Content-Type' => 'application/xml',
        ]);
    }

    // Genera el Identificador del Acreedor SEPA para Espaa: ES + 2 dgitos de control + sufijo 000 + NIF.
    private function buildSpanishCreditorId(string $nif): string
    {
        $nif    = strtoupper(preg_replace('/[^A-Z0-9]/', '', $nif));
        $suffix = '000';
        $body   = $suffix . $nif;

        // Convertimos ES a numrico (E=14, S=28) y aadimos 00 para el clculo del mdulo 97
        $numeric = '';
        foreach (str_split($body . 'ES00') as $char) {
            $numeric .= ctype_alpha($char) ? (string) (ord($char) - 55) : $char;
        }

        // bcmod para nmeros grandes; fallback si no est disponible
        if (function_exists('bcmod')) {
            $mod = (int) bcmod($numeric, '97');
        } else {
            $mod = 0;
            foreach (str_split($numeric) as $digit) {
                $mod = (($mod * 10) + (int) $digit) % 97;
            }
        }

        $check = str_pad((string) (98 - $mod), 2, '0', STR_PAD_LEFT);

        return 'ES' . $check . $suffix . $nif;
    }



    public function save(): mixed
    {
        $this->validate();

        $this->memberType->update([
            'season_id'    => $this->season_id,
            'name'         => $this->name,
            'description'  => $this->description ?: null,
            'price'        => (float) $this->price,
            'periodicity'  => $this->periodicity,
            'active'       => $this->active,
            'bank_account' => $this->bank_account,
            'credit_card'  => $this->credit_card,
        ]);

        // 3. Verifica que se haya subido un objeto de archivo válido antes de guardar
        if ($this->card_template instanceof UploadedFile) {
            $photoPath = $this->card_template->store('member_types/card_templates', 'public');
            $this->memberType->update(['card_template' => $photoPath]);
        }

        session()->flash('message', 'Tipo de socio actualizado correctamente.');

        return redirect()->route('member-types.index');
    }

    public function render(): \Illuminate\View\View
    {
        $seasons = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->orderByDesc('from_year')
            ->get();

        $periodicities = MemberPeriodicity::cases();

        return view('livewire.member-types.edit', compact('seasons', 'periodicities'));
    }
}