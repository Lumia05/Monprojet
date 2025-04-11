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
            $table->date('date');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->time("heure_entr")->nullable();
            $table->time("heure_srt")->nullable();
            $table->enum('status', ['absent', 'present', 'en conge']);
            $table->string('qr_token')->nullable();

            // $table->softDeletes();

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
