<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sentido extends Model
{
    use HasFactory;

    const ENTRADA = 'E';
    const SAIDA = 'S';
    const INDETERMINADO = 'I';

    protected $table = 'sentido';

}
