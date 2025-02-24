<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriticalEventsTable extends Migration
{
    public function up()
    {
        Schema::create('critical_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_type'); // 'Login' สำหรับ login success, 'Login Failed' สำหรับ login failed
            $table->string('ip_address')->nullable(); // สำหรับ Login Failed
            $table->string('email')->nullable(); // สำหรับ API Requests
            $table->integer('count'); // จำนวนเหตุการณ์
            $table->timestamp('event_time'); // เวลาของเหตุการณ์
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('critical_events');
    }
}