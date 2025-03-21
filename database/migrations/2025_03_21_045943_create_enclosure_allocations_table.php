<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enclosure_allocations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crocodile_id');
            $table->unsignedBigInteger('enclosure_id');
            $table->timestamps();

            $table->foreign('crocodile_id')->references('id')->on('crocodiles')->onDelete('cascade');
            $table->foreign('enclosure_id')->references('id')->on('enclosures')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enclosure_allocations');
    }
};
