<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $table = "endereco";
    protected $fillable = [
        "rua",
        "numero",
        "complemento",
        "bairro",
        "cidade",
        "estado",
        "cep"
    ];

    public function usuario()
    {
        $this->belongsTo(Users::class, 'endereco', 'id');
    }
}
