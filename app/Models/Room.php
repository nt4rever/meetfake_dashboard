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
        'roomId', 'status', 'host',
    ];
    public $timestamps = true;
}
