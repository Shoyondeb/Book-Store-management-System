<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('zoom_meetings', function (Blueprint $table) {
            // Change start_url to TEXT
            $table->text('start_url')->nullable()->change();
            // Also change join_url to TEXT (it might be long too)
            $table->text('join_url')->change();
            // Change zoom_response to LONGTEXT
            $table->longText('zoom_response')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('zoom_meetings', function (Blueprint $table) {
            // Revert back to string
            $table->string('start_url', 500)->nullable()->change();
            $table->string('join_url', 500)->change();
            $table->json('zoom_response')->nullable()->change();
        });
    }
};
