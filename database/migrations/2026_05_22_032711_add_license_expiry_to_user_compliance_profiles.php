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
        Schema::table('user_compliance_profiles', function (Blueprint $table) {
            $table->date('license_expiry_date')->nullable()->after('notify_days_before');
            $table->tinyInteger('fy_end_month')->default(12)->after('license_expiry_date')
                  ->comment('Financial year end month (1-12). Default December.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_compliance_profiles', function (Blueprint $table) {
            $table->dropColumn(['license_expiry_date', 'fy_end_month']);
        });
    }
};
