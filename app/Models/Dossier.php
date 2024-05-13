<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    use HasFactory;
    protected $fillable = ['date_depot_prevu','statue','description','client_id','type_dossier_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function type_dossier()
    {
        return $this->belongsTo(TypeDossier::class);
    }
    public function MetaData_Fichiers()
    {
        return $this->hasMany(MetaData_Fichier::class);
    }

   public function type_fichiers()
   {
    return $this->belongsToMany(typeFichier::class)
        ->using(DossierTypeFichier::class)
        ->withTimestamps();
   }
}
