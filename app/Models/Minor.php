<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Minor extends Model
{
    use HasFactory;

    protected $fillable = ['university_id', 'country', 'city', 'specifics', 'accommodation',
        'semester_start', 'semester_end', 'lower_living_expense', 'higher_living_expense', 'prerequisites', 'user_id'];

    /**
     * Establishes connection with the user model
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Establishes connection with the university model
     * @return BelongsTo
     */
    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
