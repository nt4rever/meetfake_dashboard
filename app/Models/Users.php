<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $table = 'tbl_user';
    protected $primaryKey = 'id';

    protected $fillable = [
        'email', 'fullname', 'phone', 'address', 'password', 'token',
    ];
    public $timestamps = true;
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
