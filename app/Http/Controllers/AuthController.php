<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function getSms(){

        return 'getsms';
    }

    public function verifyCode(){

        return 'verifycodee';
    }
}
