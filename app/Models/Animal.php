<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $table = 'animal';

    protected $fillable = [
        'apelido',
        'descricao',
        'foto',
        'usuario',
        'sexo',
        'ano',
        'mes'
    ];

    public function tipo()
    {
        return $this->hasOne(TipoAnimal::class, 'id', 'tipo');
    }

    public function publicacoes()
    {
        return $this->belongsToMany(Publicacao::class, 'publicacao_animal', 'animal', 'publicacao');
    }
}
