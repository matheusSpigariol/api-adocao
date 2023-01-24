<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;

class Users extends Model
{
    use HasFactory, HasApiTokens;
    
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable= [
        'name',
        'email',
        'password',
        "endereco",
        "foto",
        "data_aniversario"
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function endereco()
    {
        return $this->hasOne(Endereco::class, 'id', 'endereco');
    }
}
