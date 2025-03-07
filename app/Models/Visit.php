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
        'poc_id'
    ];

    // Constants for each field value to make it more readable
    const UPDATE_FLOW_VISITED = 0;
    const UPDATE_FLOW_MEETING_DONE = 1;
    const UPDATE_FLOW_DEMO_GIVEN = 2;

    const CONTACT_METHOD_TELEPHONIC = 0;
    const CONTACT_METHOD_IN_PERSON_MEETING = 1;

    const UPDATE_STATUS_RUNNING = 0;
    const UPDATE_STATUS_CONVERTED = 1;
    const UPDATE_STATUS_REJECTED = 2;

    // Accessors to get readable values instead of integers
    public function getUpdateFlowAttribute($value)
    {
        $statuses = [
            self::UPDATE_FLOW_VISITED => 'visited',
            self::UPDATE_FLOW_MEETING_DONE => 'meeting_done',
            self::UPDATE_FLOW_DEMO_GIVEN => 'demo_given'
        ];

        return $statuses[$value] ?? 'unknown';
    }

    public function getContactMethodAttribute($value)
    {
        $methods = [
            self::CONTACT_METHOD_TELEPHONIC => 'telephonic',
            self::CONTACT_METHOD_IN_PERSON_MEETING => 'in_person_meeting',
        ];

        return $methods[$value] ?? 'unknown';
    }

    public function getUpdateStatusAttribute($value)
    {
        $statuses = [
            self::UPDATE_STATUS_RUNNING => 'running',
            self::UPDATE_STATUS_CONVERTED => 'converted',
            self::UPDATE_STATUS_REJECTED => 'rejected',
        ];

        return $statuses[$value] ?? 'unknown';
    }

    // Relationships
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
