<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            // Add author_id foreign key
            $table->foreignId('author_id')->nullable()->constrained()->onDelete('set null');

            // Keep old author field for migration, we'll remove it later
            $table->string('old_author')->nullable()->after('author');
        });

        // Copy existing author names to old_author temporarily
        \Illuminate\Support\Facades\DB::statement('UPDATE books SET old_author = author');
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->dropColumn(['author_id', 'old_author']);
        });
    }
};
