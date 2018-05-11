<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Partner.
 *
 * @package App
 */
class Partner extends Model
{
    protected $guarded = [];

    /**
     * Get the prizes for the partner.
     */
    public function prizes()
    {
        return $this->hasMany(Prize::class);
    }

    /**
     * Find by name.
     *
     * @param $name
     * @return mixed
     */
    public static function findByName($name)
    {
        return self::where('name',$name)->first();
    }
}
