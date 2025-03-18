<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class CrocodilesController extends Controller
{
    public function index(): Response
    {
        if (! Auth::user()->hasPermission('manage_crocodiles')) {
            abort(403, 'You do not have permission to access this page.');
        }

        return Inertia::render('Crocodiles/Index', [
            'crocodiles' => Auth::user()->account->crocodiles()
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Crocodiles/Create');
    }

    public function store(): RedirectResponse
    {
        Request::validate([
            'name' => ['required', 'max:100'],
            'age' => ['required', 'integer'],
            'weight' => ['required', 'numeric'],
            'pool_id' => ['required', 'integer'],
        ]);

        Auth::user()->account->crocodiles()->create([
            'name' => Request::get('name'),
            'age' => Request::get('age'),
            'weight' => Request::get('weight'),
            'pool_id' => Request::get('pool_id'),
        ]);

        return Redirect::route('crocodiles')->with('success', '鳄鱼信息已添加。');
    }
}
