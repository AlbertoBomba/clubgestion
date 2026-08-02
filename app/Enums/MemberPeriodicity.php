<?php

namespace App\Enums;

enum MemberPeriodicity: string
{
    case Single      = 'single';
    case Monthly     = 'monthly';
    case Quarterly   = 'quarterly';
    case Semiannual  = 'semiannual';
    case Annual      = 'annual';

    public function label(): string
    {
        return match($this) {
            self::Single     => 'Pago único',
            self::Monthly    => 'Mensual',
            self::Quarterly  => 'Trimestral',
            self::Semiannual => 'Semestral',
            self::Annual     => 'Anual',
        };
    }
}
