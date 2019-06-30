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
            $table->text('bio')->nullable();
            $table->string('password');
//            $table->string('gender')->nullable();
//            $table->integer('age')->nullable();
            $table->string('address')->nullable();
            $table->string('type')->default('client');
            $table->string('phone')->nullable()->unique();
            $table->string('avatar')->nullable();
//            $table->string('personal_id_photo')->nullable();
//            $table->string('contract_file')->nullable();
            $table->string('specializations')->nullable();
            $table->integer('experience_years')->nullable();
            $table->float('service_price')->default(0);
            $table->float('balance')->default(0);
            $table->integer('total_rate')->default(0);

            $table->longText('tokens')->nullable();
            $table->string('authenticate', 30)->nullable();
            $table->boolean('notifications')->default(1);
            $table->boolean('visibility')->default(1);
            $table->boolean('status')->default(1);
            $table->string('privilege', 50)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
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
