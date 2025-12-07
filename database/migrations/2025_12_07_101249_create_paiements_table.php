<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->decimal('montant', 10, 2);
            $table->enum('mode_paiement', ['Espèce', 'OM', 'MoMo', 'Banque', 'Autre', 'Inscription', 'Fonds', 'Sanction', 'Tontine']);
            $table->enum('type_paiement', ['présentiel', 'distant']);
            $table->string('preuve_paiement', 255)->nullable();
            $table->enum('statut', ['en_attente', 'payé', 'échoué'])->default('en_attente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};