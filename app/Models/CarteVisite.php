<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarteVisite extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'entreprise', 'titre', 'coordonnees'];

}
