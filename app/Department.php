<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laratrust\Traits\LaratrustUserTrait;
use App\User;
use App\Product;

class Department extends Model
{
    use LaratrustUserTrait;

    protected $table = 'departments';
    protected $fillable = [
        'id', 'name', 'description', 'status', 'user_id'
    ];

    //-- function to get Users
    public function getUser()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    } //-- end of function 

    //-- function to get the Count product
    public function getProducts()
    {
        return $this->hasMany(Product::class);
    } //-- end function

}
