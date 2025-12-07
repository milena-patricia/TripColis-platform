<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('numero_service', 50)->unique();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->enum('type_service', ['retrait', 'envoi']);
            $table->string('agence_voyage', 255);
            $table->string('localite_agence', 255);
            $table->string('point_remise', 255);
            $table->enum('taille_colis', ['petit', 'moyen', 'grand', 'tres_grand']);
            $table->decimal('poids_approx', 8, 2);
            $table->decimal('valeur_approx', 12, 2);
            $table->boolean('fragile')->default(false);
            $table->decimal('prix_propose', 10, 2);
            $table->decimal('prix_negocie', 10, 2)->nullable();
            $table->enum('statut', ['en_attente', 'en_cours', 'accepté', 'refusé', 'terminé', 'annulé'])->default('en_attente');
            $table->foreignId('transporteur_id')->nullable()->constrained('transporters')->onDelete('set null');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};