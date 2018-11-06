<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    use \Database\seeds\SeederTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fields = ['id', 'name', 'email', 'password', 'email_verified_at', 'roles'];
        $data = [
            [2, 'Robert Plant', 'plantzeppelin@gmail.com', bcrypt('secret'), now(), json_encode(['provider'])],
            [3, 'Jimmy Page', 'jpage@gmail.com', bcrypt('secret'), now(), json_encode(['customer'])],
        ];

        $this->seedData('users', $fields, $data);
    }
}
