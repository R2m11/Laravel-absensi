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
        Schema::create('bagian', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('perusahaan_id');
            $table->foreign('perusahaan_id')->references('id')->on('perusahaan')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nama_bagian');
            $table->string('kode_bagian');
            $table->integer('tagihan_harian');
            $table->integer('tagihan_harian_perjam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bagian');
        Schema::table('bagian',function(Blueprint $table){
            $table->dropForeign('bagian_perusahaan_id_foreign');
            $table->dropColumn('perusahaan_id');
        });
    }
};
