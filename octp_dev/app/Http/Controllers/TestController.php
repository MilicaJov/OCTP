<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class TestController extends Controller
{
    public function index() {
        $users = User::all();
        return view('index')->with('users', $users);
    }
}
