<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use Inertia\Inertia;
use Inertia\Response;

class LoginLogController extends Controller
{
    public function index(): Response
    {
        $loginLogs = LoginLog::with('user')->latest()->paginate(10);

        return Inertia::render('LoginLogs/Index', [
            'loginLogs' => $loginLogs
        ]);
    }
}