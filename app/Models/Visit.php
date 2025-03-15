<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'enquiry_id',
        'date_of_visit',
        'time_of_visit',
        'visit_remarks',
        'update_flow',
        'contact_method',
        'update_status',
        'follow_up_date',
        'poc_ids',
        'expired_remarks',
        'follow_na',
        'visit_type'
    ];

    protected $casts = [
        'poc_ids' => 'array', 
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class);
    }

    public function poc()
    {
        return $this->belongsTo(Poc::class);
    }
}
