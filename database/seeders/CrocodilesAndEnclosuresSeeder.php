<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class CrocodilesAndEnclosuresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 创建一些养殖池，这里假设创建 10 个养殖池，你可以根据实际情况调整数量
        $enclosures = [];
        for ($i = 1; $i <= 10; $i++) {
            $poolId = str_pad($i, 12, '0', STR_PAD_LEFT);
            $enclosures[] = [
                'pool_id' => $poolId, // 注意这里表字段名是 pool_id
                'capacity' => rand(10, 50),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('enclosures')->insert($enclosures);

        // 获取所有养殖池的 ID
        $enclosureIds = DB::table('enclosures')->pluck('id')->toArray();

        // 创建一些鳄鱼
        $crocodiles = [];
        for ($i = 1; $i <= 20; $i++) { // 这里创建 20 条鳄鱼，你可以根据实际情况调整数量
            $uniqueId = 'CHN-' . str_pad(rand(1, 999999999999), 12, '0', STR_PAD_LEFT) . '-' . str_pad($i, 6, '0', STR_PAD_LEFT);
            $rfidTag = Str::upper(Str::random(8)) . '-' . Str::upper(Str::random(16));
            $speciesType = collect(['尼罗鳄', '湾鳄', '暹罗鳄'])->random();
            $gender = collect(['雄性', '雌性'])->random();
            $birthDate = Carbon::now()->subYears(rand(1, 20))->format('Y-m-d');
            $geneticLineage = 'Lineage-' . Str::random(5);
            $age = rand(1, 20);
            $weight = rand(100, 500) + (rand(0, 99) / 100);
            $poolId = $enclosureIds[array_rand($enclosureIds)];
            $healthStatus = collect(['健康', '患病', '康复中', '亚健康'])->random();

            $crocodiles[] = [
                'unique_id' => $uniqueId,
                'rfid_tag' => $rfidTag,
                'species_type' => $speciesType,
                'gender' => $gender,
                'birth_date' => $birthDate,
                'genetic_lineage' => $geneticLineage,
                'age' => $age,
                'weight' => $weight,
                'pool_id' => $poolId,
                'health_status' => $healthStatus,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('crocodiles')->insert($crocodiles);
    }
}