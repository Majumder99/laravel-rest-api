<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller {
    //Register api, login api, profile api, logout api
    // POST[name,email,password] /api/register
    public function register(Request $request) {
    }

    // POST[email,password] /api/login
    public function login(Request $request) {
    }

    // GET [Auth: Token] /api/profile
    public function profile() {
    }

    // GET [Auth: Token] /api/logout
    public function logout() {
    }
}
