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
        Schema::create('historique_prets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pret_id')->constrained('prets')->onDelete('cascade');
            $table->string('action'); // creation, retour, prolongation, modification
            $table->foreignId('utilisateur_id')->constrained('users')->onDelete('cascade');
            $table->json('details')->nullable();
            $table->timestamps();

            $table->index('pret_id');
            $table->index('action');
            $table->index('utilisateur_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historique_prets');
    }
};
