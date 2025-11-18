<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('visitor_schedules', function (Blueprint $table) {
            $table->id();

            $table->uuid();
            $table->date('date');
            $table->string('timeslot');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('registration_number')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visitor_schedules');
    }
};
