<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDegreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ตรวจสอบว่าตาราง degrees มีอยู่แล้วหรือไม่
        if (!Schema::hasTable('degrees')) {
            Schema::create('degrees', function (Blueprint $table) {
                $table->id();
                $table->string('degree_name_th');
                $table->string('degree_name_en');
                $table->unsignedBigInteger('department_id')->nullable();  
                $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('degrees');
    }
}
