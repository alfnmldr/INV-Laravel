<?php

namespace App\Http\Controllers;
use App\Models\UserLog;
use Illuminate\Http\Request;

class LogUserController extends Controller
{
    public function index (){
        $logs = UserLog::all();

        return view('manajer.log-user', compact('logs'));
    }
}
