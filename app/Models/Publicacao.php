<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Publicacao extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $logName = 'Log de post';

    protected $table = "Publicacao";

    protected $fillable = [
        'description',
        'user'
    ];

    public function animais()
    {
        return $this->belongsToMany(Animal::class, 'publicacao_animal', 'animal', 'publicacao');
    }
}
