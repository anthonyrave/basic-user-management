<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'deleted') && !Schema::hasColumn('users', 'deleted_at')) {
                $table->after('remember_token', function (Blueprint $table) {
                    $table->boolean('deleted')->default(false);
                });
                $table->after('updated_at', function (Blueprint $table) {
                    $table->timestamp('deleted_at')->nullable();
                });
            }
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'deleted') && Schema::hasColumn('users', 'deleted_at')) {
                $table->dropColumn(['deleted', 'deleted_at']);
            }
        });
    }
};
