<?php

namespace App\Exceptions;

use Exception;

class AuthException extends Exception
{
    public function render()
    {
        return response()->json(['error' => $this->getMessage()], 401);
    }
}
