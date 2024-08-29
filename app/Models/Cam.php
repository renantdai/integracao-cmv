<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cam extends Model {
    use HasFactory;

    protected $fillable = [
        'tipo_ambiente_id',
        'versao_aplicacao',
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

    public function settpAmbAttribute($value) {
        $this->attributes['tipo_ambiente_id'] = $value;
    }
    public function setverAplicAttribute($value) {
        $this->attributes['versao_aplicacao'] = strtoupper($value);
    }
}
