<?php

use Illuminate\Database\Seeder;

class ServiceUserTableSeeder extends Seeder
{
    use \Database\seeds\SeederTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fields = ['service_id', 'user_id'];
        $data = [
            [1, 2],
            [2, 2],
        ];

        $this->seedData('service_user', $fields, $data, ['service_id', 'user_id'], false);
    }
}
