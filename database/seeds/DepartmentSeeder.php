<?php

use App\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = ['Seel phone', 'Books'];

        foreach ($departments as $department) {
            Department::create([
                'name'  => $department,
                'user_id'   => 1,
                'description'   => 'demo description',
            ]);
        }
    } //-- end of run

} //-- end of seeder
