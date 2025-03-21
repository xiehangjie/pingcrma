<?php

namespace App\Http\Controllers;

use App\Models\Crocodile;
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
        if (! Auth::user()->hasPermission('manage_crocodiles')) {
            abort(403, '您没有权限访问此页面。');
        }

        return Inertia::render('Crocodiles/Management/Index');
    }

    // 鳄鱼信息列表
    public function crocodileIndex(): Response
    {
        if (! Auth::user()->hasPermission('manage_crocodiles')) {
            abort(403, '您没有权限访问此页面。');
        }

        // 获取鳄鱼信息列表，按照 unique_id 排序
        $crocodiles = Crocodile::orderBy('unique_id')->get();

        // 返回渲染后的视图，并传递鳄鱼信息列表
        return Inertia::render('Crocodiles/Management/BasicInfo/Index', [
            'crocodiles' => $crocodiles,
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
        $messages = [
            'unique_id.required' => '唯一编号为必填项。',
            'unique_id.max' => '唯一编号长度不能超过 100 个字符。',
            'unique_id.unique' => '该唯一编号已被使用。',
            'unique_id.regex' => '唯一编号格式不正确，应为 [A-Z]{3}-[0-9]{12}-[0-9]{6}。',
            'rfid_tag.required' => 'RFID 标签为必填项。',
            'rfid_tag.max' => 'RFID 标签长度不能超过 100 个字符。',
            'rfid_tag.unique' => '该 RFID 标签已被使用。',
            'rfid_tag.regex' => 'RFID 标签格式不正确，应为 [A-Z0-9]{8}-[A-Z0-9]{16}。',
            'species_type.required' => '物种类型为必填项。',
            'species_type.max' => '物种类型长度不能超过 100 个字符。',
            'gender.required' => '性别为必填项。',
            'gender.in' => '性别只能为 雄性 或 雌性。',
            'birth_date.date' => '出生日期格式不正确。',
            'genetic_lineage.required' => '遗传谱系为必填项。',
            'genetic_lineage.max' => '遗传谱系长度不能超过 255 个字符。',
            'age.required' => '年龄为必填项。',
            'age.integer' => '年龄必须为整数。',
            'age.min' => '年龄不能小于 0。',
            'weight.required' => '体重为必填项。',
            'weight.numeric' => '体重必须为数字。',
            'weight.min' => '体重不能小于 0。',
            'pool_id.required' => '圈舍编号为必填项。',
            'pool_id.regex' => '圈舍编号必须是 12 位数字。',
            'health_status.string' => '健康状态必须为字符串类型。',
        ];

        Request::validate([
            'unique_id' => ['required', 'max:100', 'unique:crocodiles,unique_id', 'regex:/^[A-Z]{3}-\d{12}-\d{6}$/'],
            'rfid_tag' => ['required', 'max:100', 'unique:crocodiles,rfid_tag', 'regex:/^[A-Z0-9]{8}-[A-Z0-9]{16}$/'],
            'species_type' => ['required', 'max:100'],
            'gender' => ['required', 'in:雄性,雌性'],
            'birth_date' => ['nullable', 'date'],
            'genetic_lineage' => ['required', 'max:255'],
            'age' => ['required', 'integer', 'min:0'],
            'weight' => ['required', 'numeric', 'min:0'],
            'pool_id' => ['required', 'regex:/^\d{12}$/'],
            'health_status' => ['nullable', 'string'],
        ], $messages);

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
            abort(403, '您没有权限访问此页面。');
        }

        return Inertia::render('Crocodiles/Management/BasicInfo/Edit', [
            'crocodile' => $crocodile,
        ]);
    }

    // 更新鳄鱼信息
    public function crocodileUpdate(Crocodile $crocodile): RedirectResponse
    {
        if (! Auth::user()->hasPermission('manage_crocodiles')) {
            abort(403, '您没有权限访问此页面。');
        }

        $messages = [
            'unique_id.required' => '唯一编号为必填项。',
            'unique_id.max' => '唯一编号长度不能超过 100 个字符。',
            'unique_id.regex' => '唯一编号格式不正确，应为 [A-Z]{3}-[0-9]{12}-[0-9]{6}。',
            'rfid_tag.required' => 'RFID 标签为必填项。',
            'rfid_tag.max' => 'RFID 标签长度不能超过 100 个字符。',
            'rfid_tag.regex' => 'RFID 标签格式不正确，应为 [A-Z0-9]{8}-[A-Z0-9]{16}。',
            'species_type.required' => '物种类型为必填项。',
            'species_type.max' => '物种类型长度不能超过 100 个字符。',
            'gender.required' => '性别为必填项。',
            'gender.in' => '性别只能为 雄性 或 雌性。',
            'birth_date.date' => '出生日期格式不正确。',
            'genetic_lineage.required' => '遗传谱系为必填项。',
            'genetic_lineage.max' => '遗传谱系长度不能超过 255 个字符。',
            'age.required' => '年龄为必填项。',
            'age.integer' => '年龄必须为整数。',
            'age.min' => '年龄不能小于 0。',
            'weight.required' => '体重为必填项。',
            'weight.numeric' => '体重必须为数字。',
            'weight.min' => '体重不能小于 0。',
            'pool_id.required' => '圈舍编号为必填项。',
            'pool_id.regex' => '圈舍编号必须是 12 位数字。',
            'health_status.string' => '健康状态必须为字符串类型。',
        ];

        Request::validate([
            'unique_id' => ['required', 'max:100', 'regex:/^[A-Z]{3}-\d{12}-\d{6}$/'],
            'rfid_tag' => ['required', 'max:100', 'regex:/^[A-Z0-9]{8}-[A-Z0-9]{16}$/'],
            'species_type' => ['required', 'max:100'],
            'gender' => ['required', 'in:雄性,雌性'],
            'birth_date' => ['nullable', 'date'],
            'genetic_lineage' => ['required', 'max:255'],
            'age' => ['required', 'integer', 'min:0'],
            'weight' => ['required', 'numeric', 'min:0'],
            'pool_id' => ['required', 'string', 'regex:/^\d{12}$/'], // 修改为字符串类型，且必须是12位数字
            'health_status' => ['nullable', 'string'],
        ], $messages);

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
            abort(403, '您没有权限访问此页面。');
        }

        $crocodile->delete();

        return Redirect::route('crocodile-management.basic-info')->with('success', '鳄鱼信息已删除。');
    }
}
