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
        Schema::create('formation__utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->string('liste_candidature');
            $table->unsignedBigInteger('id_formation');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_formation')->references('id')->on('formations')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formation__utilisateurs');
    }
};
