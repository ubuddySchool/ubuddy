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
            // Add new columns
            $table->string('expired_remarks')->nullable();
            $table->string('follow_na')->nullable(); // Adding the follow_na column
            $table->integer('visit_type')->default(0);

            // Modify the existing columns to ensure they are of type DATE
            $table->date('date_of_visit')->change();
            $table->date('follow_up_date')->nullable()->change(); // Make follow_up_date nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            // Drop the columns only if they exist
            if (Schema::hasColumn('visits', 'visit_type')) {
                $table->dropColumn('visit_type');
            }
            if (Schema::hasColumn('visits', 'expired_remarks')) {
                $table->dropColumn('expired_remarks');
            }
            if (Schema::hasColumn('visits', 'follow_na')) {
                $table->dropColumn('follow_na');
            }

            // Revert the column types back to string (or original types)
            // In case the column is already in DATE type, it will change back to string
            $table->string('date_of_visit')->change();
            $table->string('follow_up_date')->nullable()->change(); // Changing it to string and nullable
        });
    }
};
