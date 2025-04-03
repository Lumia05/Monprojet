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
        Schema::create('presences',function (Blueprint $table){
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp("heure_entr")->nullable();
            $table->timestamp("heure_srt")->nullable();
            $table->enum('status', ['absent', 'present', 'en conge']);

            // $table->string('id');

        });
      

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
