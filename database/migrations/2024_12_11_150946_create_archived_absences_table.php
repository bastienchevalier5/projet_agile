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
        Schema::create('archived_absences', function (Blueprint $table) {
            $table->id();
            $table->date('debut');
            $table->date('fin');
            $table->bigInteger('motif_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps(); // Inclut 'created_at' et 'updated_at'
            $table->timestamp('archived_at')->nullable(); // Nouveau champ pour marquer la date d'archivage
            $table->boolean('statut')->default(false); // Nouveau champ pour marquer le statut de l'absences
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archived_absences');
    }
};
