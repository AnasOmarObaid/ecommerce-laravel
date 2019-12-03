<?php

namespace App;

use App\User;
use App\Department;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['id', 'name', 'description', 'status', 'allow_ads', 'allow_commend', 'image', 'purchase_price', 'sale_price', 'stock', 'department_id', 'user_id'];

    //-- function to get the user
    public function getUser()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    //-- function to get the department
    function getDepartment()
    {
        return $this->belongsTo('App\Department', 'department_id', 'id');
    } //-- end function


    //-- function to get the profict for this product
    function getProfit()
    {
        $profit = $this->sale_price - $this->purchase_price;
        return $profit;
    } //-- end function
}
