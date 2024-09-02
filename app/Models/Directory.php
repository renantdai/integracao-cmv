<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directory extends Model
{
    use HasFactory;

    protected $table = 'diretorios';

    protected $fillable = [
        'cameras_id',
        'tipo_conexao_id',
        'diretorio',
        'host',
        'login',
        'password',
        'porta',
        'situacao_registro_id',
        'usuario_criacao'
    ];
}
