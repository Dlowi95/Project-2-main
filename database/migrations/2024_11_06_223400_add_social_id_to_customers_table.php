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
        Schema::table('customers', function (Blueprint $table) {
            // Thêm cột google_id và facebook_id nếu chưa có
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();

            // Kiểm tra và thêm cột code nếu chưa tồn tại
            if (!Schema::hasColumn('customers', 'code')) {
                $table->string('code', 20)->notNull();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Xóa các cột vừa thêm
            $table->dropColumn(['google_id', 'facebook_id', 'code']);
        });
    }
};
