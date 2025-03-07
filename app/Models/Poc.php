<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poc extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'enquiry_id',
        'poc_name',
        'poc_designation',
        'poc_number'
    ];

    // Relationships (if needed)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class);
    }
}
