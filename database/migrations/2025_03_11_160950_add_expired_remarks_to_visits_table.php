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
        Schema::table('visits', function (Blueprint $table) {
           
            $table->string('expired_remarks')->nullable();
            $table->string('follow_na')->nullable();  // Adding the follow_na column
            $table->integer('visit_type')->default(0);
            // Modify the existing columns to ensure they are of type DATE
            $table->date('date_of_visit')->change();
            $table->date('follow_up_date')->nullable()->change();  // Make follow_up_date nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn('visit_type');
            $table->dropColumn('expired_remarks');
            $table->dropColumn('follow_na');
            $table->string('date_of_visit')->change();
            $table->string('follow_up_date')->change();  
        });
    }
};
