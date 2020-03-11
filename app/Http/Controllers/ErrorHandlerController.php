<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ErrorHandlerController extends Controller
{
    public function error_404() {
        return response()->json([
            'error' => true,
            'message' => 'Page not found. If error persists, contact ' . get_option_value('technical_mail')
        ], Response::HTTP_NOT_FOUND);
    }
}
