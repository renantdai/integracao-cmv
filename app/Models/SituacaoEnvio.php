<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SituacaoEnvio extends Model
{
    use HasFactory;

    const RECEBIDO = '1';
    const ENVIADO = '2';
    const ERRO = '3';
    const CADASTRADO = '4';

    protected $table = 'situacao_envio';

}
