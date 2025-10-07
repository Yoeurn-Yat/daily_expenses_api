<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\ClientRepository;

class PassportClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Artisan::call('passport:keys',['--force' => true]);

        $repository = new ClientRepository();
        $repository->createPersonalAccessGrantClient('Laravel Personal Access Client');
        $repository->createPasswordGrantClient('Laravel Password Grant Client');
    }
}
