<?php

declare(strict_types=1);

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
        Schema::create('loan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inventory_id')->constrained()->cascadeOnDelete();
            $table->date('returned_at')->nullable();
            $table->enum('loan_status', ['loaned', 'returned'])->default('loaned');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_details', function (Blueprint $table) {
            $table->dropForeign(['loan_id']);
            $table->dropForeign(['inventory_id']);
        });

        Schema::dropIfExists('loan_details');
    }
};
