<?php

namespace App\Http\Controllers;

use App\Support\ReturnResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller
{
    use ReturnResponse, ValidatesRequests, AuthorizesRequests;
}
