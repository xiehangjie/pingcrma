<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enclosures', function (Blueprint $table) {
            $table->id();
            $table->string('pool_id')->unique();
            $table->integer('capacity');
            // 添加养殖池类型字段，假设类型用字符串表示，长度可根据实际情况调整
            $table->string('pool_type', 100)->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enclosures');
    }
};