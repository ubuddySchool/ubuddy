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
        Schema::table('enquiries', function (Blueprint $table) {
            $table->unsignedTinyInteger('interest_software')
                  ->nullable()
                  ->comment('0 = Not Interested, 1 = Interested, 2 = Highly Interested')
                  ->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropColumn('interest_software');
        });
    }
};
