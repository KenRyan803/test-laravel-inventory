<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('type')->default('Admin');
            $table->mediumtext('bio')->default('New Guy')->nullable();
            $table->string('photo')->default('profile.png')->nullable();
            // $table->string('photo')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        $password = 'testing08';
        // Insert USERS
        
        DB::table('users')->insert(
            [
                'name' => 'TESTING',
                'email' => 'test@test.com',
                'password' => Hash::make($password),
                'type' => 'ADMIN',
                'bio' => 'NEW GUY',
                'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s"))),
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );
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
