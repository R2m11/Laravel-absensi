<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('profile', function(Blueprint $table){
        $table->id();
        $table->string('kode_karyawan')->unique();
        $table->string('gender');
        $table->string('address');
        $table->string('phone_number');
        $table->string('profile_picture')->nullable();
        $table->unsignedBigInteger('users_id');
        $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        $table->unsignedBigInteger('gajiharian_id');
        $table->foreign('gajiharian_id')->references('id')->on('gaji_harian')->onUpdate('cascade')->onDelete('cascade');
        $table->timestamps();

       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile');
        Schema::table('profile',function(Blueprint $table){
            $table->dropForeign('profile_users_id_foreign');
            $table->dropColumn('users_id');
        });
    }
};
