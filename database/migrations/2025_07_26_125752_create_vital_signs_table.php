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
        Schema::create('vital_signs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checkup_id');
            $table->foreign('checkup_id')->references('id')->on('checkups')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->unsignedBigInteger('type_vital_id');
            $table->foreign('type_vital_id')->references('id')->on('type_vitals')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->float('value',20,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vital_signs');
    }
};
