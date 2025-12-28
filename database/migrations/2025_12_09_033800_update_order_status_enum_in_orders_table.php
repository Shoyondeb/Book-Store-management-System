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
        DB::statement("
            ALTER TABLE orders MODIFY status ENUM(
                'pending',
                'payment_submitted',
                'payment_verification',
                'paid',
                'processing',
                'shipped',
                'ready_for_pickup',
                'completed',
                'cancelled',
                'payment_failed'
            ) DEFAULT 'pending'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE orders MODIFY status ENUM(
                'pending',
                'processing',
                'completed',
                'cancelled'
            ) DEFAULT 'pending'
        ");
    }
};
