<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('times', function (Blueprint $table) {
            $table->increments('id');
            $table->time('theTime')->nullable();
        });

        \Illuminate\Support\Facades\DB::statement("INSERT INTO `times` (`id`, `theTime`) VALUES
                (1, '00:00:00'),
                (2, '00:30:00'),
                (3, '01:00:00'),
                (4, '01:30:00'),
                (5, '02:00:00'),
                (6, '02:30:00'),
                (7, '03:00:00'),
                (8, '03:30:00'),
                (9, '04:00:00'),
                (10, '04:30:00'),
                (11, '05:00:00'),
                (12, '05:30:00'),
                (13, '06:00:00'),
                (14, '06:30:00'),
                (15, '07:00:00'),
                (16, '07:30:00'),
                (17, '08:00:00'),
                (18, '08:30:00'),
                (19, '09:00:00'),
                (20, '09:30:00'),
                (21, '10:00:00'),
                (22, '10:30:00'),
                (23, '11:00:00'),
                (24, '11:30:00'),
                (25, '12:00:00'),
                (26, '12:30:00'),
                (27, '13:00:00'),
                (28, '13:30:00'),
                (29, '14:00:00'),
                (30, '14:30:00'),
                (31, '15:00:00'),
                (32, '15:30:00'),
                (33, '16:00:00'),
                (34, '16:30:00'),
                (35, '17:00:00'),
                (36, '17:30:00'),
                (37, '18:00:00'),
                (38, '18:30:00'),
                (39, '19:00:00'),
                (40, '19:30:00'),
                (41, '20:00:00'),
                (42, '20:30:00'),
                (43, '21:00:00'),
                (44, '21:30:00'),
                (45, '22:00:00'),
                (46, '22:30:00'),
                (47, '23:00:00'),
                (48, '23:30:00')"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('times');
    }
}
