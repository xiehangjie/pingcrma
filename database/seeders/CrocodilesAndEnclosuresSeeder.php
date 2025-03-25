<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CrocodilesAndEnclosuresSeeder extends Seeder
{
    public function run()
    {
        // 创建养殖池数据
        $enclosures = [];
        $poolTypes = ['小鳄鱼池', '成年鳄鱼池', '繁殖池', '病鳄隔离池'];
        for ($i = 1; $i <= 10; $i++) {
            $poolId = str_pad($i, 12, '0', STR_PAD_LEFT);
            $poolType = collect($poolTypes)->random();
            $enclosures[] = [
                'pool_id' => $poolId,
                'capacity' => rand(10, 50),
                'pool_type' => $poolType,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('enclosures')->insert($enclosures);

        // 获取养殖池的 pool_id
        $enclosurePoolIds = DB::table('enclosures')->pluck('pool_id')->toArray();

        // 生成父母鳄鱼数据
        $parentCrocodiles = [];
        for ($i = 1; $i <= 10; $i++) {
            $uniqueId = 'CHN-'.str_pad(rand(1, 999999999999), 12, '0', STR_PAD_LEFT).'-'.str_pad($i, 6, '0', STR_PAD_LEFT);
            $rfidTag = Str::upper(Str::random(8)).'-'.Str::upper(Str::random(16));
            $speciesType = collect(['尼罗鳄', '湾鳄', '暹罗鳄'])->random();
            $gender = collect(['雄性', '雌性'])->random();
            // 修正日期格式
            $birthDate = Carbon::now()->subYears(rand(1, 20))->format('Y-m-d');
            // 使用特殊标识表示没有遗传谱系
            $geneticLineage = '未知';
            $age = rand(1, 20);
            $weight = rand(100, 500) + (rand(0, 99) / 100);
            $poolId = $enclosurePoolIds[array_rand($enclosurePoolIds)];
            $healthStatus = collect(['健康', '患病', '康复中', '亚健康'])->random();

            $parentCrocodiles[] = [
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
        DB::table('crocodiles')->insert($parentCrocodiles);

        // 生成普通鳄鱼数据
        $crocodiles = [];
        for ($i = 1; $i <= 20; $i++) {
            $uniqueId = 'CHN-'.str_pad(rand(1, 999999999999), 12, '0', STR_PAD_LEFT).'-'.str_pad($i + count($parentCrocodiles), 6, '0', STR_PAD_LEFT);
            $rfidTag = Str::upper(Str::random(8)).'-'.Str::upper(Str::random(16));
            $speciesType = collect(['尼罗鳄', '湾鳄', '暹罗鳄'])->random();
            $gender = collect(['雄性', '雌性'])->random();
            // 修正日期格式
            $birthDate = Carbon::now()->subYears(rand(1, 20))->format('Y-m-d');
            $age = rand(1, 20);
            $weight = rand(100, 500) + (rand(0, 99) / 100);
            $poolId = $enclosurePoolIds[array_rand($enclosurePoolIds)];
            $healthStatus = collect(['健康', '患病', '康复中', '亚健康'])->random();

            // 随机选择两个父母鳄鱼
            $parent1 = $parentCrocodiles[array_rand($parentCrocodiles)];
            $parent2 = $parentCrocodiles[array_rand($parentCrocodiles)];
            $geneticLineage = "{$parent1['gender']}: {$parent1['unique_id']}\n{$parent2['gender']}: {$parent2['unique_id']}";
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
