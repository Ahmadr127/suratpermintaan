<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // JSON array of route groups this role can access
            // e.g. ["staff", "user"] — matches keys in RoleMiddleware::GROUPS
            $table->json('allowed_groups')->nullable()->after('redirect_to');
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('allowed_groups');
        });
    }
};
