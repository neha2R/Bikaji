<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "rahul",
            'email' => "rmodi2407@gmail.com",
            'mobile' => "9024829041",
            'password'=>'$2y$10$.m.iUXAG2FUVBqg7K46WL.jOTWteDnLv2U8qGKbENO1Us8JHxBCTC',
            'role'=>1
        ]);
    }
}
