<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_enquiries_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiriesTable extends Migration
{
    public function up()
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('school_name');
            $table->string('board');
            $table->string('other_board_name')->nullable();
            $table->string('address');
            $table->string('pincode');
            $table->string('city')->nullable();    
            $table->string('state')->nullable();   
            $table->string('country')->nullable();
            $table->string('website')->nullable();
            $table->string('website_url')->nullable();
            $table->integer('students_count')->nullable();
            $table->boolean('current_software')->default(false);
            $table->string('status')->default('0');
            $table->string('software_details')->nullable();
            $table->text('remarks')->nullable();
            $table->string('poc_name')->nullable();
            $table->string('poc_designation')->nullable();
            $table->string('poc_contact')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('enquiries');
    }
}
