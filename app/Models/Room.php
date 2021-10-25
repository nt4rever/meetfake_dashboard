<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table = 'tbl_room';
    protected $primaryKey = 'id';

    protected $fillable = [
        'roomId', 'title', 'status', 'host',
    ];
    public $timestamps = true;

    public function owner()
    {
        return $this->belongsTo(Users::class, 'host');
    }
}
