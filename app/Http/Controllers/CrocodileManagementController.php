<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Crocodile;

class CrocodileManagementController extends Controller
{
    // 鳄鱼信息管理首页
    public function index(): Response
    {
        if (! Auth::user()->hasPermission('manage_crocodiles')) {
            abort(403, 'You do not have permission to access this page.');
        }

        return Inertia::render('Crocodiles/Management/Index');
    }

    // 鳄鱼信息列表
    public function crocodileIndex(): Response
    {
        if (! Auth::user()->hasPermission('manage_crocodiles')) {
            abort(403, 'You do not have permission to access this page.');
        }

         // 获取鳄鱼信息列表，按照 unique_id 排序
         $crocodiles = Crocodile::orderBy('unique_id')->get();

         // 返回渲染后的视图，并传递鳄鱼信息列表
         return Inertia::render('Crocodiles/Management/BasicInfo/Index', [
             'crocodiles' => $crocodiles
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
            'unique_id' => ['required', 'max:100', 'unique:crocodiles,unique_id'],
            'rfid_tag' => ['required', 'max:100', 'unique:crocodiles,rfid_tag'],
            'species_type' => ['required', 'max:100'],
            'gender' => ['required', 'in:公,母'],
            'birth_date' => ['nullable', 'date'],
            'genetic_lineage' => ['required', 'max:255'],
            'age' => ['required', 'integer', 'min:0'],
            'weight' => ['required', 'numeric', 'min:0'],
            'pool_id' => ['required', 'integer'],
            'health_status' => ['nullable', 'string'],
        ]);

        Crocodile::create([
            'unique_id' => Request::get('unique_id'),
            'rfid_tag' => Request::get('rfid_tag'),
            'species_type' => Request::get('species_type'),
            'gender' => Request::get('gender'),
            'birth_date' => Request::get('birth_date'),
            'genetic_lineage' => Request::get('genetic_lineage'),
            'age' => Request::get('age'),
            'weight' => Request::get('weight'),
            'pool_id' => Request::get('pool_id'),
            'health_status' => Request::get('health_status'),
        ]);

        return Redirect::route('crocodile-management.basic-info')->with('success', '鳄鱼信息已添加。');
    }

    // 编辑鳄鱼信息页面
    public function crocodileEdit(Crocodile $crocodile): Response
    {
        if (! Auth::user()->hasPermission('manage_crocodiles')) {
            abort(403, 'You do not have permission to access this page.');
        }

        return Inertia::render('Crocodiles/Management/BasicInfo/Edit', [
            'crocodile' => $crocodile,
        ]);
    }

    // 更新鳄鱼信息
    public function crocodileUpdate(Crocodile $crocodile): RedirectResponse
    {
        if (! Auth::user()->hasPermission('manage_crocodiles')) {
            abort(403, 'You do not have permission to access this page.');
        }

        Request::validate([
            'unique_id' => ['required', 'max:100'],
            'rfid_tag' => ['required', 'max:100'],
            'species_type' => ['required', 'max:100'],
            'gender' => ['required', 'in:公,母'],
            'birth_date' => ['nullable', 'date'],
            'genetic_lineage' => ['required', 'max:255'],
            'age' => ['required', 'integer', 'min:0'],
            'weight' => ['required', 'numeric', 'min:0'],
            'pool_id' => ['required', 'integer'],
            'health_status' => ['nullable', 'string'],
        ]);

        $crocodile->update([
            'unique_id' => Request::get('unique_id'),
            'rfid_tag' => Request::get('rfid_tag'),
            'species_type' => Request::get('species_type'),
            'gender' => Request::get('gender'),
            'birth_date' => Request::get('birth_date'),
            'genetic_lineage' => Request::get('genetic_lineage'),
            'age' => Request::get('age'),
            'weight' => Request::get('weight'),
            'pool_id' => Request::get('pool_id'),
            'health_status' => Request::get('health_status'),
        ]);

        return Redirect::route('crocodile-management.basic-info')->with('success', '鳄鱼信息已更新。');
    }

    // 删除鳄鱼信息
    public function crocodileDelete(Crocodile $crocodile): RedirectResponse
    {
        if (! Auth::user()->hasPermission('manage_crocodiles')) {
            abort(403, 'You do not have permission to access this page.');
        }

        $crocodile->delete();

        return Redirect::route('crocodile-management.basic-info')->with('success', '鳄鱼信息已删除。');
    }
}    