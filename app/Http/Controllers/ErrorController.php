<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sys\ErrorLogs;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ErrorController extends Controller
{
    public function store($id, $url, $error)
    {
        $error = base64_decode($error);
        $log = ErrorLogs::create([
            'url' => str_replace('.', '/', $url),
            'user_id' => $id,
            'log' => $error,
            'created_at' => NOW(),
        ]);

        return redirect()->route('error/log',['id' => $log->id]);
    }

    public function log($id)
    {
        return view('error', compact('id'));
    }
}