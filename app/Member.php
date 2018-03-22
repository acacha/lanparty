<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Member.
 *
 * @package App
 */
class Member extends Model
{
    protected $guarded = [];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    //Create AND OBSERVER TO CAPTURE CREATING 
}
