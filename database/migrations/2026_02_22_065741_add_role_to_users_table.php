<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('mobile');
        });

        // Migrate existing roles
        if (Schema::hasTable('roles')) {
            $users = DB::table('users')->get();
            foreach ($users as $user) {
                if ($user->role_id) {
                    $role = DB::table('roles')->where('id', $user->role_id)->first();
                    if ($role) {
                        DB::table('users')->where('id', $user->id)->update(['role' => $role->slug]);
                    }
                }
            }
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null');
        });

        // Revert data if possible
        if (Schema::hasTable('roles')) {
            $users = DB::table('users')->get();
            foreach ($users as $user) {
                $role = DB::table('roles')->where('slug', $user->role)->first();
                if ($role) {
                    DB::table('users')->where('id', $user->id)->update(['role_id' => $role->id]);
                }
            }
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
