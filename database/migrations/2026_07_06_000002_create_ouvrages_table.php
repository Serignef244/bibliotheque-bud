<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ouvrages', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 255);
            $table->string('slug', 265)->unique();
            $table->string('isbn', 20)->unique()->nullable();
            $table->text('auteurs');             // JSON ou texte séparé par virgule
            $table->string('editeur', 150)->nullable();
            $table->string('langue', 50)->default('Français');
            $table->year('annee_publication')->nullable();
            $table->text('description')->nullable();
            $table->string('image_couverture')->nullable();
            $table->unsignedInteger('nombre_pages')->nullable();
            $table->string('format', 50)->nullable();   // PDF, Broché, Relié…
            $table->unsignedInteger('nombre_exemplaires_total')->default(0);
            $table->unsignedInteger('nombre_exemplaires_disponibles')->default(0);
            $table->boolean('actif')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Table pivot polymorphique catégorie <-> ouvrage
        Schema::create('ouvrage_categorie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ouvrage_id')->constrained('ouvrages')->cascadeOnDelete();
            $table->foreignId('categorie_id')->constrained('categories')->cascadeOnDelete();
            $table->boolean('principale')->default(false); // catégorie principale de l'ouvrage
            $table->timestamps();

            $table->unique(['ouvrage_id', 'categorie_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ouvrage_categorie');
        Schema::dropIfExists('ouvrages');
    }
};
