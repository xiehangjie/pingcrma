<?php

namespace App\Http\Controllers;

use App\Models\Crocodile;
use App\Models\Enclosure;
use App\Models\EnclosureAllocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class EnclosureManagementController extends Controller
{
    public function index(): Response
    {
        $enclosures = Enclosure::with('crocodiles')->get();

        return Inertia::render('Crocodiles/Management/Enclosure/Index', [
            'enclosures' => $enclosures,
        ]);
    }

    public function crocodileIndex(): Response
    {
        if (! Auth::user()->hasPermission('manage_crocodiles')) {
            abort(403, '您没有权限访问此页面。');
        }

        // 获取鳄鱼信息列表，按照 unique_id 排序，并关联养殖池信息
        $crocodiles = Crocodile::with('pool')->orderBy('unique_id')->get();

        // 返回渲染后的视图，并传递鳄鱼信息列表
        return Inertia::render('Crocodiles/Management/BasicInfo/Index', [
            'crocodiles' => $crocodiles,
        ]);
    }

    public function allocate(Request $request)
    {
        try {
            $request->validate([
                'crocodile_id' => 'required|exists:crocodiles,id',
                'enclosure_id' => 'required|exists:enclosures,id',
            ]);

            EnclosureAllocation::create([
                'crocodile_id' => $request->crocodile_id,
                'enclosure_id' => $request->enclosure_id,
            ]);

            return redirect()->back()->with('success', '圈舍分配成功。');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '圈舍分配失败：'.$e->getMessage());
        }
    }

    public function autoAllocate()
    {
        try {
            $crocodiles = Crocodile::all();
            $enclosures = Enclosure::withCount('crocodiles')->orderByDesc('capacity')->get();

            // 存储无法分配的鳄鱼信息
            $unallocatedCrocodiles = [];

            foreach ($crocodiles as $crocodile) {
                $suitableEnclosure = null;

                // 优先选择剩余容量大的圈舍
                foreach ($enclosures as $key => $enclosure) {
                    if ($enclosure->crocodiles_count < $enclosure->capacity) {
                        $suitableEnclosure = $enclosure;
                        // 更新圈舍的使用情况
                        $enclosures[$key]->crocodiles_count++;
                        break;
                    }
                }

                if ($suitableEnclosure) {
                    EnclosureAllocation::create([
                        'crocodile_id' => $crocodile->id,
                        'enclosure_id' => $suitableEnclosure->id,
                    ]);
                } else {
                    $unallocatedCrocodiles[] = $crocodile;
                }
            }

            if (! empty($unallocatedCrocodiles)) {
                // 可以在这里记录日志或者发送通知，告知有鳄鱼无法分配
                Log::info('以下鳄鱼无法分配到圈舍：', array_column($unallocatedCrocodiles, 'id'));
            }

            return redirect()->back()->with('success', '自动圈舍分配完成。');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '自动圈舍分配失败：'.$e->getMessage());
        }
    }

    private function findSuitableEnclosure(Crocodile $crocodile)
    {
        // 这里可以实现基于鳄鱼体型数据智能算法自动匹配合适圈舍的逻辑
        $enclosures = Enclosure::all();
        foreach ($enclosures as $enclosure) {
            $currentCount = $enclosure->crocodiles->count();
            if ($currentCount < $enclosure->capacity) {
                return $enclosure;
            }
        }

        return null;
    }

    public function updateStatusOnIsolation($crocodileId)
    {
        try {
            $allocation = EnclosureAllocation::where('crocodile_id', $crocodileId)->first();
            if ($allocation) {
                $allocation->delete();
            }

            return redirect()->back()->with('success', '圈舍分配状态已更新。');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '圈舍分配状态更新失败：'.$e->getMessage());
        }
    }

    // 添加更新圈舍信息的方法
    public function update(Request $request, Enclosure $enclosure)
    {
        try {
            $request->validate([
                'pool_id' => 'required',
                'capacity' => 'required|integer',
            ]);

            $enclosure->update($request->all());

            return redirect()->back()->with('success', '圈舍信息更新成功。');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '圈舍信息更新失败：'.$e->getMessage());
        }
    }

    // 添加删除圈舍的方法
    public function destroy(Enclosure $enclosure)
    {
        try {
            $enclosure->delete();

            return redirect()->back()->with('success', '圈舍删除成功。');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '圈舍删除失败：'.$e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'pool_id' => 'required|unique:enclosures,pool_id',
            'capacity' => 'required|integer',
            'pool_type' => 'nullable|string',
        ]);

        // 只使用需要的字段创建圈舍
        $data = $request->only(['pool_id', 'capacity', 'pool_type']);
        Enclosure::create($data);

        return redirect()->route('crocodile-management.enclosure')->with('success', '圈舍创建成功。');
    }
}
