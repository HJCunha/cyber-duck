<?php

use Illuminate\Database\Seeder;

class CompaniesAndEmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Company::class, 25)->create();
        factory(App\Employee::class, 500)->create();
    }
}
