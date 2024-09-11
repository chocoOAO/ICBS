<?php

namespace App\Exceptions;

use Exception;

class NotFoundChickenImportException extends Exception
{
    public function render($request)
    {
        // return response()->view('errors.not_found_chicken_import', [], 404);
        return response()->view('errors.build-chickenimport-first', [], 404);
    }
}
