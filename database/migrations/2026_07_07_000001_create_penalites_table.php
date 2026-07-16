<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penalites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pret_id')->constrained('prets')->cascadeOnDelete();
            $table->foreignId('adherent_id')->constrained('adherents')->cascadeOnDelete();
            $table->integer('montant')->default(0);
            $table->integer('jours_retard')->default(0);
            $table->string('statut')->default('non_paye');
            $table->date('date_echeance')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penalites');
    }
};
