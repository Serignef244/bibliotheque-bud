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
        Schema::table('penalites', function (Blueprint $table) {
            $table->integer('montant_restant')->default(0)->after('montant');
            $table->date('date_paiement')->nullable()->after('statut');
        });

        // Modification du statut existant vers un enum ou une string compatible
        // On update d'abord les anciennes données (si la DB est MySQL, on peut avoir des soucis de cast avec ENUM, donc on garde string pour l'instant avec contrainte via modèle)
        // Mais comme demandé, on s'assure que statut peut prendre 'impaye', 'paye', 'partiel'
        // 'non_paye' devient 'impaye'
        \Illuminate\Support\Facades\DB::table('penalites')->where('statut', 'non_paye')->update(['statut' => 'impaye']);
        
        Schema::table('penalites', function (Blueprint $table) {
            $table->dropColumn('date_echeance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penalites', function (Blueprint $table) {
            $table->dropColumn('montant_restant');
            $table->dropColumn('date_paiement');
            $table->date('date_echeance')->nullable();
        });
        
        \Illuminate\Support\Facades\DB::table('penalites')->where('statut', 'impaye')->update(['statut' => 'non_paye']);
    }
};
