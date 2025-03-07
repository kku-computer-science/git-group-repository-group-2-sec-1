<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('logs')) {
            Schema::create('logs', function (Blueprint $table) {
                $table->id();
                $table->timestamp('date_time')->useCurrent(); // วันที่และเวลา
                $table->string('kkumail'); // อีเมลผู้ใช้
                $table->string('action'); // กิจกรรมที่เกิดขึ้น เช่น login, logout
                $table->text('details')->nullable(); // รายละเอียดเพิ่มเติม (เช่น User ID ที่ถูกแก้ไข)
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('logs');
    }
};

