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
        'images',
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
        'interest_software',
        ];

    protected $casts = [
        'students_count' => 'integer',
       
    ];


    public function user()
{
    return $this->belongsTo(User::class);
}

public function visits()
{
    return $this->hasMany(Visit::class, 'enquiry_id');
}


}

