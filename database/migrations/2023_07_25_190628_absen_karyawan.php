<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absen_karyawan',function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('absensi_id');
            $table->foreign('absensi_id')->references('id')->on('absensi')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('bagian_id');
            $table->foreign('bagian_id')->references('id')->on('bagian')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('userbagian_id');
            $table->foreign('userbagian_id')->references('id')->on('user_bagian')->onUpdate('cascade')->onDelete('cascade');
            $table->time('absen_masuk')->nullable();
            $table->time('absen_keluar')->nullable();
            $table->string('foto_absen')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absen_karyawan');
    }
};
