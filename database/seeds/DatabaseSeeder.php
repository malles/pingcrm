<?php

use App\Models\Account;
use App\Models\Park;
use App\Models\Product;
use App\Models\Supplier;
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

        factory(Park::class, 20)->create([
            'account_id' => $account->id,
        ]);

        factory(Supplier::class, 5)->create([
            'account_id' => $account->id,
        ])->each(function (Supplier $supplier) use ($account) {
            factory(Product::class, 4)->create([
                'account_id' => $account->id,
                'supplier_id' => $supplier->id,
            ]);
        });


    }
}
