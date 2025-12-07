<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chartes', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 255);
            $table->string('fichier_path', 255);
            $table->string('version', 20);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chartes');
    }
};