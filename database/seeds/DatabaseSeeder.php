<?php

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $account = Account::create(['name' => 'ACO Center Parcs']);

        factory(User::class)->create([
            'account_id' => $account->id,
            'first_name' => 'Matthijs',
            'last_name' => 'Alles',
            'email' => 'matthijs@ferm.app',
            'password' => env('SEEDER_PASSWORD', 'secret'),
            'owner' => true,
        ]);

    }
}
