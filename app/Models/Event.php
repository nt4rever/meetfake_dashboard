<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'tbl_calendar';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'title', 'start', 'end', 'allDay', 'daysOfWeek', 'url', 'backgroundColor', 'borderColor', 'edit'
    ];
    public $timestamps = true;
}
