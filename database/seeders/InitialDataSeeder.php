<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Role;
use App\Services\ProjectEnumsService;
use Illuminate\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::factory(1)->create([
            'name' => 'manager',
            'display_name' => 'Менеджер отеля',
        ]);

        foreach (ProjectEnumsService::facilities() as $facility) {
            Facility::factory(1)->create([
                'name' => $facility,
            ]);
        }
    }
}
