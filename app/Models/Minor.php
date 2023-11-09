<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Minor extends Model
{
    use HasFactory;

    protected $fillable = ['university_name', 'country', 'city', 'specifics', 'accommodation',
        'semester_start', 'semester_end', 'lower_living_expense', 'higher_living_expense', 'prerequisites'];
}
