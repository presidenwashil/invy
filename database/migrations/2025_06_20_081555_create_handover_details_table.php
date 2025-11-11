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
        Schema::create('handover_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('handover_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inventory_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('handover_details', function (Blueprint $table) {
            $table->dropForeign(['handover_id']);
            $table->dropForeign(['inventory_id']);
        });

        Schema::dropIfExists('handover_details');
    }
};
