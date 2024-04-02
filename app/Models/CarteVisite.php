<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarteVisite extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'nom','tel',  'entreprise', 'titre', 'coordonnees','description'];
    protected $table = 'cartes_visites';

}
