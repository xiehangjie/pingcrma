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
        Schema::create('crocodiles', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id', 100)->unique();
            $table->string('rfid_tag', 100)->unique();
            $table->string('species_type', 100);
            $table->enum('gender', ['雄性', '雌性']);
            $table->date('birth_date');
            $table->string('genetic_lineage', 255);
            $table->integer('age');
            $table->decimal('weight', 8, 2);
            $table->bigInteger('pool_id');
            $table->string('health_status', 255);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crocodiles');
    }
};
