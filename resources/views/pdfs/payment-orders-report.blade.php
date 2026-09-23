<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de Cartas de Pago</title>
    <style>
        @page { margin: 12mm 12mm; }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 8.5pt;
            color: #1e293b;
            background: #ffffff;
            line-height: 1.3;
        }

        .header {
            width: 100%;
            border-bottom: 2px solid #059669;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .header-table { width: 100%; }
        .school-name {
            font-size: 13pt;
            font-weight: bold;
            color: #065f46;
            text-transform: uppercase;
        }
        .doc-title {
            font-size: 11pt;
            font-weight: bold;
            color: #0f172a;
            text-align: right;
        }
        .doc-date {
            font-size: 7.5pt;
            color: #64748b;
            text-align: right;
            margin-top: 2px;
        }

        .summary {
            font-size: 8pt;
            color: #475569;
            margin-bottom: 10px;
        }
        .summary strong { color: #0f172a; }

        table.data {
            width: 100%;
            border-collapse: collapse;
            font-size: 7.5pt;
        }
        table.data thead th {
            background: #059669;
            color: #ffffff;
            font-weight: bold;
            text-align: left;
            padding: 6px 5px;
            border: 1px solid #047857;
            text-transform: uppercase;
            font-size: 7pt;
        }
        table.data tbody td {
            padding: 5px;
            border: 1px solid #e2e8f0;
            vertical-align: top;
            word-wrap: break-word;
        }
        table.data tbody tr:nth-child(even) td {
            background: #f8fafc;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 7pt;
            color: #94a3b8;
            text-align: center;
            padding-top: 4px;
            border-top: 1px solid #e2e8f0;
        }

        .empty {
            text-align: center;
            padding: 30px 10px;
            color: #94a3b8;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 60%;">
                    <div class="school-name">{{ $schoolName ?? 'Club Deportivo' }}</div>
                </td>
                <td style="width: 40%;">
                    <div class="doc-title">Informe de Cartas de Pago</div>
                    <div class="doc-date">Generado: {{ $generated->format('d/m/Y H:i') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="summary">
        Total de registros: <strong>{{ count($records) }}</strong>
    </div>

    @if(count($records) > 0)
        <table class="data">
            <thead>
                <tr>
                    @foreach($columns as $key => $label)
                        <th>{{ $label }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                    <tr>
                        @foreach($columns as $key => $label)
                            <td>{{ $record->{$key} ?? '-' }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty">No hay registros que coincidan con los filtros seleccionados.</div>
    @endif

    <div class="footer">
        {{ $schoolName ?? 'Club Deportivo' }} · Página {PAGENO} de {nbpg}
    </div>
</body>
</html>
