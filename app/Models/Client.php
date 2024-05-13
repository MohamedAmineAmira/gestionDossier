<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['nom','prenom','email','tel'];
    use HasFactory;
    public function dossiers()
    {
        return $this->hasMany(Dossier::class);
    }
}
