<?php
// database/migrations/xxxx_add_payment_columns_to_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('status');
            $table->text('payment_details')->nullable()->after('payment_method');
            $table->string('transaction_id')->nullable()->after('payment_details');
            $table->string('payment_status')->default('pending')->after('transaction_id');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_details', 'transaction_id', 'payment_status']);
        });
    }
};
