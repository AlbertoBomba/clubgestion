<?php

namespace App\Enums;

enum MemberPaymentStatus: string
{
    case Pending  = 'pending';
    case Paid     = 'paid';
    case Overdue  = 'overdue';
    case Refunded = 'refunded';
    case Canceled = 'canceled';

    public function label(): string
    {
        return match($this) {
            self::Pending  => 'Pendiente',
            self::Paid     => 'Pagado',
            self::Overdue  => 'Vencido',
            self::Refunded => 'Devuelto',
            self::Canceled => 'Cancelado',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pending  => 'yellow',
            self::Paid     => 'green',
            self::Overdue  => 'red',
            self::Refunded => 'blue',
            self::Canceled => 'gray',
        };
    }
}
