<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $account = Account::create(['name' => 'Acme Corporation']);

        // 使用 updateOrCreate 方法避免重复插入
        User::updateOrCreate(
            ['email' => 'johndoe@example.com'],
            [
                'account_id' => $account->id,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'password' => 'secret',
                'owner' => true,
            ]
        );

        User::factory(5)->create(['account_id' => $account->id]);

        $organizations = Organization::factory(100)
            ->create(['account_id' => $account->id]);

        Contact::factory(100)
            ->create(['account_id' => $account->id])
            ->each(function ($contact) use ($organizations) {
                $contact->update(['organization_id' => $organizations->random()->id]);
            });
            
        $this->call(CrocodilesAndEnclosuresSeeder::class);
    }
}
