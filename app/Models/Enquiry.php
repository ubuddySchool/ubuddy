<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

   
    protected $table = 'enquiries';

    protected $fillable = [
        'user_id',  
        'school_name',
        'board',
        'other_board_name',
        'address',
        'pincode',
        'city',
        'state',
        'country',
        'website',
        'website_url',
        'students_count',
        'current_software',
        'software_details',
        'remarks',
        'poc_details',
        // 'poc_name',
        // 'poc_designation',
        // 'poc_contact',
    ];

    protected $casts = [
        'current_software' => 'boolean',
        'students_count' => 'integer',
        //  'poc_details' => 'array'
    ];


    public function user()
{
    return $this->belongsTo(User::class);
}
}

