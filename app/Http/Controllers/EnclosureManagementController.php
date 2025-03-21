<?php

namespace App\Http\Controllers;

use App\Models\Crocodile;
use App\Models\Enclosure;
use App\Models\EnclosureAllocation;
use Illuminate\Http\Request;
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

    public function allocate(Request $request)
    {
        $request->validate([
            'crocodile_id' => 'required|exists:crocodiles,id',
            'enclosure_id' => 'required|exists:enclosures,id',
        ]);

        EnclosureAllocation::create([
            'crocodile_id' => $request->crocodile_id,
            'enclosure_id' => $request->enclosure_id,
        ]);

        return redirect()->back()->with('success', '圈舍分配成功。');
    }

    public function autoAllocate()
    {
        $crocodiles = Crocodile::all();
        foreach ($crocodiles as $crocodile) {
            // 基于鳄鱼体型数据智能算法自动匹配合适圈舍
            $suitableEnclosure = $this->findSuitableEnclosure($crocodile);
            if ($suitableEnclosure) {
                EnclosureAllocation::create([
                    'crocodile_id' => $crocodile->id,
                    'enclosure_id' => $suitableEnclosure->id,
                ]);
            }
        }

        return redirect()->back()->with('success', '自动圈舍分配完成。');
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
        $allocation = EnclosureAllocation::where('crocodile_id', $crocodileId)->first();
        if ($allocation) {
            $allocation->delete();
        }

        return redirect()->back()->with('success', '圈舍分配状态已更新。');
    }
}
