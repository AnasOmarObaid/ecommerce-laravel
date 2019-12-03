<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $table = 'clients';

    public $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'image',
        'password',
        'address',
    ];
}
