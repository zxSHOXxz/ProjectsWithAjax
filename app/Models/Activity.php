<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    public function sub_activities()
    {
        return $this->hasMany(SubActivity::class);
    }
    public function project()
    {
        return $this->belongsTo(SubActivity::class);
    }
}
