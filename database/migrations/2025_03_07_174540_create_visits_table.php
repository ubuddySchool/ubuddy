<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('enquiry_id')->constrained()->onDelete('cascade'); // Foreign key to enquiries table
            $table->string('date_of_visit');
            // $table->date('date_of_visit');
            $table->string('time_of_visit');
            $table->text('visit_remarks')->nullable();
            
            // Store 0 for 'visited', 1 for 'meeting_done', 2 for 'demo_given'
            $table->tinyInteger('update_flow')->default(0)->comment('0 = visited, 1 = meeting_done, 2 = demo_given');
            
            // Store 0 for 'telephonic', 1 for 'in_person_meeting'
            $table->tinyInteger('contact_method')->default(0)->comment('0 = telephonic, 1 = in_person_meeting');
            
            // Store 0 for 'running', 1 for 'converted', 2 for 'rejected'
            $table->tinyInteger('update_status')->default(0)->comment('0 = running, 1 = converted, 2 = rejected');
            
            $table->string('follow_up_date')->nullable(); // If follow-up date is not fixed, leave as null
            $table->json('poc_ids')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
