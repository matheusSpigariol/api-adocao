<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;

class Users extends Model
{
    use HasFactory, HasApiTokens;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $logName = 'Log de usuario';
    
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable= [
        'name',
        'email',
        'password'
    ];
}
