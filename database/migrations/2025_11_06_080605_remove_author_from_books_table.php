<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            // Remove the old author field
            $table->dropColumn('author');

            // Also remove the temporary old_author field if it exists
            if (Schema::hasColumn('books', 'old_author')) {
                $table->dropColumn('old_author');
            }
        });
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('author')->after('title');
        });
    }
};
