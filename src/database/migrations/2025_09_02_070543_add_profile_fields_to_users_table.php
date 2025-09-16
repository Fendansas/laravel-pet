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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('id');
            $table->string('avatar')->nullable()->after('email');
            $table->string('phone')->nullable()->after('avatar');
            $table->text('bio')->nullable()->after('phone');
            $table->boolean('is_active')->default(true)->after('password');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
            $table->string('last_login_ip')->nullable()->after('last_login_at');
            $table->timestamp('last_activity_at')->nullable()->after('last_login_ip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'avatar',
                'phone',
                'bio',
                'is_active',
                'last_login_at',
                'last_login_ip',
                'last_activity_at'
            ]);
        });
    }
};
