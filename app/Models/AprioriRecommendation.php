<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AprioriRecommendation extends Model
{
    use HasFactory;
    protected $fillable = ['itemA', 'itemB', 'confidence','support'];
}
