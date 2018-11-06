<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verify_email_token')->nullable();
            $table->string('password');
            $table->json('roles');
            $table->timestamps();
            $table->softDeletes();
        });

        app('db')->table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@tanamao.club',
            'password' => bcrypt(config('auth.admin-secret')),
            'verify_email_token' => null,
            'email_verified_at' => now(),
            'roles' => json_encode(['admin'])
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
