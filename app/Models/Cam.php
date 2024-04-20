<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cam extends Model
{
    use HasFactory;

    protected $fillable = [
        'tpAmb',
        'verAplic',
        'tpMan',
        'dhReg',
        'CNPJOper',
        'cEQP',
        'xEQP',
        'cUF',
        'tpSentido',
        'latitude',
        'longitude',
        'tpEQP',
        'xRefCompl',
        'statusSend'
    ];
}
