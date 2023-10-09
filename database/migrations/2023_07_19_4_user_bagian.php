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
        Schema::create('user_bagian', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('bagian_id');
            $table->foreign('bagian_id')->references('id')->on('bagian')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nama_user_bagian')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_bagian');
        Schema::table('user_bagian',function(Blueprint $table){
            $table->dropForeign('user_bagian_bagian_id_foreign	');
            $table->dropColumn('bagian_id');
        });
    }
};
