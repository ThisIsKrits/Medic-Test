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
        Schema::create('checkup_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checkup_id');
            $table->foreign('checkup_id')->references('id')->on('checkups')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->string('document')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkup_files');
    }
};
