<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('role_user') && !Schema::hasColumn('role_user', 'user_type')) {
            Schema::table('role_user', function (Blueprint $table) {
                $table->string('user_type')->nullable()->after('user_id');
            });

            DB::table('role_user')
                ->whereNull('user_type')
                ->update(['user_type' => 'sayhuite\\Usuario']);
        }

        if (Schema::hasTable('permission_user') && !Schema::hasColumn('permission_user', 'user_type')) {
            Schema::table('permission_user', function (Blueprint $table) {
                $table->string('user_type')->nullable()->after('user_id');
            });

            DB::table('permission_user')
                ->whereNull('user_type')
                ->update(['user_type' => 'sayhuite\\Usuario']);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('permission_user') && Schema::hasColumn('permission_user', 'user_type')) {
            Schema::table('permission_user', function (Blueprint $table) {
                $table->dropColumn('user_type');
            });
        }

        if (Schema::hasTable('role_user') && Schema::hasColumn('role_user', 'user_type')) {
            Schema::table('role_user', function (Blueprint $table) {
                $table->dropColumn('user_type');
            });
        }
    }
};

