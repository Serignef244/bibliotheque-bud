<?php

use App\Enums\StatutExemplaire;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exemplaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ouvrage_id')->constrained('ouvrages')->cascadeOnDelete();
            $table->string('code_barre', 50)->unique();
            $table->string('cote', 50)->nullable();  // localisation physique en rayonnage
            $table->string('statut', 30)->default(StatutExemplaire::DISPONIBLE->value);
            $table->date('date_acquisition')->nullable();
            $table->decimal('prix_acquisition', 10, 2)->nullable();
            $table->string('fournisseur', 150)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedTinyInteger('etat')->default(5);   // 1 (mauvais) → 5 (neuf)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exemplaires');
    }
};
