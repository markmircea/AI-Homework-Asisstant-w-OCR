<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyQuestionCount extends Model
{
    protected $fillable = ['user_id', 'date', 'count'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
