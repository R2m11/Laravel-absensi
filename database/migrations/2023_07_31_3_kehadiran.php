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
        Schema::create('kehadiran', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('absenkaryawan_id');
            $table->foreign('absenkaryawan_id')->references('id')->on('absen_karyawan')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('bagian_id');
            $table->foreign('bagian_id')->references('id')->on('bagian')->onUpdate('cascade')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('status');
            $table->string('ket');
            $table->unsignedBigInteger('gajiharian_id');
            $table->foreign('gajiharian_id')->references('id')->on('gaji_harian')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('lemburharian_id');
            $table->foreign('lemburharian_id')->references('id')->on('lembur_harian')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadiran');
        Schema::table('absen_karyawan',function(Blueprint $table){
            $table->dropForeign('kehadiran_absenkaryawan_id_foreign');
            $table->dropColumn('absenkaryawan_id');
        });
    }
};
