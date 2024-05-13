<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaData_Fichier extends Model
{
    use HasFactory;
    protected $fillable = ['nom_fichier','nom_type_fichier','date_ech','lien','id_dossier'];

    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }
}
