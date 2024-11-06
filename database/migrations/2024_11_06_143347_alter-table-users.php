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
        Schema::table('users', function (Blueprint $table) {
            $table->string('poste')->nullable();
            $table->string('service')->nullable();
            $table->integer('age')->nullable();
            $table->date('date_embauche')->nullable();
            $table->string('duree_anciennete')->nullable();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('poste','service','age','date_embauche','duree_anciennete');
        });
    }
};
