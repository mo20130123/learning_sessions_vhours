<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopularQuestion extends Model
{
    protected $table = 'popular_questions';
    protected $fillable = [
        'question_en','question_ar','answer_en','answer_ar','status','position'
    ];
}
