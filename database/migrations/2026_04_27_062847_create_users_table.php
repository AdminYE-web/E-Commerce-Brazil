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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');

            // ข้อมูลผู้ใช้
            $table->string('name', 150)->nullable();
            $table->string('email', 254)->unique();
            $table->string('phone', 20)->nullable()->unique();

            // รหัสผ่าน
            $table->string('password');

            // สถานะบัญชี
            $table->tinyInteger('status')->default(1)->comment('0=inactive, 1=active, 2=banned');

            // ยืนยันอีเมล
            $table->timestamp('email_verified_at')->nullable();

            // สำหรับ remember me ตอน login
            $table->rememberToken();

            // เวลาล็อกอินล่าสุด
            $table->timestamp('last_login_at')->nullable();

            // วันสร้าง/แก้ไขข้อมูล
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
