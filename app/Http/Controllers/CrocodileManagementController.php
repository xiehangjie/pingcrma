<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class CrocodileManagementController extends Controller
{
    // 鳄鱼信息管理首页
    public function index(): Response
    {
        if (!Auth::user()->hasPermission('manage_crocodiles')) {
            abort(403, 'You do not have permission to access this page.');
        }

        return Inertia::render('Crocodiles/Management/Index');
    }

    // 鳄鱼信息列表
    public function crocodileIndex(): Response
    {
        if (!Auth::user()->hasPermission('manage_crocodiles')) {
            abort(403, 'You do not have permission to access this page.');
        }

        return Inertia::render('Crocodiles/Management/BasicInfo/Index', [
            'crocodiles' => Auth::user()->account->crocodiles()
                ->orderBy('name')
                ->get(),
        ]);
    }

    // 创建鳄鱼信息页面
    public function crocodileCreate(): Response
    {
        return Inertia::render('Crocodiles/Management/BasicInfo/Create');
    }

    // 保存鳄鱼信息
    public function crocodileStore(): RedirectResponse
    {
        Request::validate([
            'name' => ['required', 'max:100'],
            'age' => ['required', 'integer'],
            'weight' => ['required', 'numeric'],
            'pool_id' => ['required', 'integer'],
            'gender' => ['required', 'in:male,female'], // 假设性别只有男和女
            'birth_date' => ['nullable', 'date'],
            'health_status' => ['nullable', 'string'],
        ]);

        Auth::user()->account->crocodiles()->create([
            'name' => Request::get('name'),
            'age' => Request::get('age'),
            'weight' => Request::get('weight'),
            'pool_id' => Request::get('pool_id'),
            'gender' => Request::get('gender'),
            'birth_date' => Request::get('birth_date'),
            'health_status' => Request::get('health_status'),
        ]);

        return Redirect::route('crocodile-management.basic-info')->with('success', '鳄鱼信息已添加。');
    }
}
