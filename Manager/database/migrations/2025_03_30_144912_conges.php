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
        Schema::create('conges',function (Blueprint $table){
            $table->id();
            $table->timestamps();
            $table->softDeletes(); 
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();  
            $table->date('date_debut');
            $table->date('date_fin');
            $table->enum('type', ['conge_paye', 'conge_sans_solde']);
            $table->enum('status', ['en_attente', 'approuve', 'rejete']);
            $table->text('motif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conges');
    }
};
