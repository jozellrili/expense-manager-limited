<?php

use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**git sta
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'title' => 'Administrator', 'description' => 'Can manage other users'],
            ['id' => 2, 'title' => 'User', 'description' => 'Simple User'],

        ];

        foreach ($items as $item) {
            \App\Role::create($item);
        }
    }
}
