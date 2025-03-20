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
        Schema::create('login_logs', function (Blueprint $table) {
            $table->id();
            // 修改为 unsignedInteger 类型
            $table->unsignedInteger('user_id')->comment('用户 ID'); 
            $table->string('ip_address', 45)->comment('登录 IP 地址');
            $table->timestamp('login_time')->comment('登录时间');
            $table->timestamps();

            // 建立外键关联
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_logs');
    }
};
