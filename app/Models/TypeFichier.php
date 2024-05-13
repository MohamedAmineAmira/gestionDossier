<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeFichier extends Model
{
    use HasFactory;
    
    protected $fillable = ['id','nom','description'];
    
    public function Dossiers()
   {
    return $this->belongsToMany(Dossier::class);
    
   }

}
