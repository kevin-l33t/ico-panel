<?php

use Illuminate\Database\Seeder;

class TransactionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert User Role
        DB::table('transaction_types')->insert([
            'name' => 'Ethereum'
        ]);

        DB::table('transaction_types')->insert([
            'name' => 'Bank Transfer'
        ]);

        DB::table('transaction_types')->insert([
            'name' => 'Credit Card'
        ]);

        DB::table('transaction_types')->insert([
            'name' => 'System Allocation'
        ]);
    }
}
