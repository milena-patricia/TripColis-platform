<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transporters', function (Blueprint $table) {
            $table->id();
            $table->string('matricule', 50)->unique();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('cni', 20)->unique();
            $table->string('permis_numero', 50);
            $table->string('telephone', 20);
            $table->string('quartier', 100);
            $table->string('carte_grise', 100);
            $table->string('police_assurance', 100);
            $table->date('validite_assurance');
            $table->enum('mode_paiement', ['Espèce', 'OM', 'MoMo', 'Banque', 'Autre']);
            $table->boolean('frais_inscription_payes')->default(false);
            $table->enum('statut', ['en_attente', 'actif', 'suspendu', 'rejeté'])->default('en_attente');
            $table->string('contrat_path', 255)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transporters');
    }
};