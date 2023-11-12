<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class University extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country'];


    /**
     * Establishes connection with the minor model
     * @return HasMany
     */
    public function minors(): HasMany
    {
        return $this->hasMany(Minor::class);
    }

    public static function chosenFromUsersByProgramme(Programme $programme)
    {
        return self::whereHas('minors.user.programme', function ($query) use ($programme) {
            $query->where('programme_id', $programme->id);
        })->get();
    }
}
