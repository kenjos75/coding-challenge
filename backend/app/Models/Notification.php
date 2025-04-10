<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];

    /**
     * Relationship: A notification belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Add any custom logic or methods as needed.
     */
}
