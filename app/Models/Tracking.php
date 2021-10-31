<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;
    protected $table = 'tbl_tracking';
    protected $primaryKey = 'id';

    protected $fillable = [
        'room_id', 'user_id', 'ip', 'start', 'end',
    ];
    public $timestamps = true;

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(Users::class);
    }
}
