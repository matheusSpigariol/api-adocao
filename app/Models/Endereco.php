<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Endereco extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $logName = 'Log de post';

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
