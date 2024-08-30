<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAmbiente extends Model
{
    use HasFactory;

    const PRODUÇÃO = '1';
    const HOMOLOGAÇÃO = '2';

    protected $table = 'tipo_ambiente';

}
