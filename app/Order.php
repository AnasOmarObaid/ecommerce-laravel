<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Client;
use App\Product;

class Order extends Model
{

    protected $guarded = ['_method', '_token'];
    protected $table = 'orders';
    protected $fillable = ['id', 'client_id', 'product_id', 'quantity', 'total_price'];

    public function getUser()
    {
        return $this->belongsTo('App\Client', 'client_id', 'id');
    } //-- end get User function


    public function getProduct()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    } //-- end get product function

}//-- end of order
