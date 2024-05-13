<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeDossier extends Model
{
    use HasFactory;
    protected $fillable = ['nom','description'];

    public function dossiers()
    {
        return $this->hasMany(Dossier::class);
    }

}
