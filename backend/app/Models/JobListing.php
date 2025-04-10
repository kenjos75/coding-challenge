<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    use HasFactory;

    // Define the table name (optional, Laravel can usually infer this)
    protected $table = 'job_listings';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'is_approve',
    ];

    /**
     * Relationship: A job listing belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Add any custom logic or methods as needed.
     */
}
