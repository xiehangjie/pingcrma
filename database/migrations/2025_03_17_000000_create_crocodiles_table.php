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
            $table->string('name')->comment('鳄鱼名称');
            $table->integer('age')->comment('鳄鱼年龄');
            $table->decimal('weight', 8, 2)->comment('鳄鱼体重');
            $table->string('gender', 10)->comment('鳄鱼性别');
            $table->date('birth_date')->nullable()->comment('鳄鱼出生日期');
            $table->integer('pool_id')->index()->comment('所在养殖池 ID');
            $table->text('health_status')->nullable()->comment('健康状况描述');
            $table->timestamps();
            $table->softDeletes();
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