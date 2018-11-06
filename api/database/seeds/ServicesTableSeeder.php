<?php

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    use \Database\seeds\SeederTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fields = ['id', 'name'];
        $data = [
            [1, 'Instalar chuveiro'],
            [2, 'Instalar quadro na parede'],
        ];

        $this->seedData('services', $fields, $data);
    }
}
