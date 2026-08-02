<?php

namespace App\Enums;

enum MemberSeasonStatus: string
{
    case Active    = 'active';
    case Inactive  = 'inactive';
    case Suspended = 'suspended';
    case Left      = 'left';

    public function label(): string
    {
        return match($this) {
            self::Active    => 'Activo',
            self::Inactive  => 'Inactivo',
            self::Suspended => 'Suspendido',
            self::Left      => 'Baja',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Active    => 'green',
            self::Inactive  => 'gray',
            self::Suspended => 'orange',
            self::Left      => 'red',
        };
    }
}
