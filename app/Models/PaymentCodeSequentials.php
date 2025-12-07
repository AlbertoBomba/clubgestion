<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PaymentCodeSequentials extends Model
{
    use HasFactory;

    /**
     * Get  code payment
     *
     * @return string code
     *
     */
    public static function getCode(
        
    ) {
        $letters='TRWAGMYFPDXBNJZSQVHLCKE';
        $code = '';
      
            $sequential = 0;
            DB::transaction(function () use (&$sequential) {
                $tbc_sequential = PaymentCodeSequentials::all()->first();
                $sequential = $tbc_sequential->sequential;
                $tbc_sequential->sequential++;
                $tbc_sequential->save([],false);
            }, 5);

            $number = ($sequential % 1000000) % 23;
            $code = date("y").($sequential % 1000000).substr($letters,$number,1);

        return $code;
    }

}
