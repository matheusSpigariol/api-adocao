<?php

namespace App\Helpers;

abstract class AuthHelper
{
    static function verificaAuth($dado)
    {
        if($dado!= auth()->user()->id)
            return response()->json(["error" => "Você não possuí autorização para isso."], 401);

        return [];
    }
}