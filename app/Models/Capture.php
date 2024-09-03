<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capture extends Model
{
    use HasFactory;

    protected $table = 'capturas';

    protected $fillable = [
        'cameras_id',
        'situacao_envio_id',
        'placa',
        'nome_imagem',
        'local_imagem',
        'data_captura',
        'indice_confianca',
        'id_registro'
    ];
}
