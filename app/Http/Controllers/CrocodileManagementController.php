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
    // 鳄鱼信息列表
    public function crocodileIndex(): Response
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

    // 创建鳄鱼信息页面
    public function crocodileCreate(): Response
    {
        return Inertia::render('Crocodiles/Create');
    }

    // 保存鳄鱼信息
    public function crocodileStore(): RedirectResponse
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

        return Redirect::route('crocodile-management.crocodiles')->with('success', '鳄鱼信息已添加。');
    }

    // 以下可以添加其他五个模块的管理方法
    // 示例：模块1
    public function module1Index(): Response
    {
        // 模块1的业务逻辑
        return Inertia::render('Module1/Index', [
            // 传递数据到视图
        ]);
    }

    // 示例：模块2
    public function module2Create(): Response
    {
        // 模块2的业务逻辑
        return Inertia::render('Module2/Create', [
            // 传递数据到视图
        ]);
    }

    // 其他模块的方法...
}
