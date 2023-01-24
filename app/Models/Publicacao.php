<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacao extends Model
{
    use HasFactory;

    protected $table = "publicacao";

    protected $fillable = [
        'descricao',
        'usuario',
        'foto'
    ];

    public function animais()
    {
        return $this->belongsToMany(Animal::class, 'publicacao_animal', 'publicacao', 'animal');
    }

    public function usuario()
    {
        return $this->belongsTo(Users::class, 'usuario', 'id');
    }
}
