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
        Schema::create('prets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adherent_id')->constrained('adherents')->onDelete('cascade');
            $table->foreignId('exemplaire_id')->constrained('exemplaires')->onDelete('cascade');
            $table->dateTime('date_emprunt');
            $table->date('date_retour_prevue');
            $table->date('date_retour_reelle')->nullable();
            $table->boolean('prolonge')->default(false);
            $table->enum('statut', ['en_cours', 'rendu', 'retard'])->default('en_cours');
            $table->text('remarques')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['adherent_id', 'statut']);
            $table->index(['exemplaire_id', 'statut']);
            $table->index('date_retour_prevue');
            $table->index('date_retour_reelle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prets');
    }
};
