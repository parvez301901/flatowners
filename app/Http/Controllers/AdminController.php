<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //Log Out Link
    public function Logout() {
        Auth::logout();
        return Redirect()->route('login');
    }
}
