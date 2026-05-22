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
        Schema::create('user_custom_deadlines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('profile_id')->nullable()->index();
            $table->string('title');
            $table->date('due_date');
            $table->text('notes')->nullable();
            $table->string('category')->default('Custom');
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence')->nullable(); // 'monthly', 'quarterly', 'annual'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_custom_deadlines');
    }
};
