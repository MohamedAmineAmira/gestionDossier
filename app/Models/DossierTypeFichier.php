<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DossierTypeFichier extends Pivot
{
    use HasFactory;
    protected $table = 'dossier_type_fichier';
}
