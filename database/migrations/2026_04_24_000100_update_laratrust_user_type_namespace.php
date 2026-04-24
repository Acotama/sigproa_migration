<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('role_user') && Schema::hasColumn('role_user', 'user_type')) {
            DB::table('role_user')
                ->where('user_type', 'sayhuite\\Usuario')
                ->update(['user_type' => 'sayhuite\\Models\\Usuario']);
        }

        if (Schema::hasTable('permission_user') && Schema::hasColumn('permission_user', 'user_type')) {
            DB::table('permission_user')
                ->where('user_type', 'sayhuite\\Usuario')
                ->update(['user_type' => 'sayhuite\\Models\\Usuario']);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('role_user') && Schema::hasColumn('role_user', 'user_type')) {
            DB::table('role_user')
                ->where('user_type', 'sayhuite\\Models\\Usuario')
                ->update(['user_type' => 'sayhuite\\Usuario']);
        }

        if (Schema::hasTable('permission_user') && Schema::hasColumn('permission_user', 'user_type')) {
            DB::table('permission_user')
                ->where('user_type', 'sayhuite\\Models\\Usuario')
                ->update(['user_type' => 'sayhuite\\Usuario']);
        }
    }
};

