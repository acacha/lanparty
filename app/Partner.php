<?php

namespace App;

use App\Traits\FormattedDates;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Partner.
 *
 * @package App
 */
class Partner extends Model
{
  use FormattedDates;

    protected $guarded = [];

  public static function partners()
  {
    return map_collection(Partner::all());
    }

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

  public function map()
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'session' => $this->session,
      'category' => $this->category,
      'avatar' => $this->avatar,
      'created_at' => $this->created_at,
      'created_at_formatted' => $this->created_at_formatted,
      'created_at_human' => $this->created_at_human,
      'created_at_timestamp'=>$this->created_at_timestamp,
      'updated_at' => $this->updated_at,
      'updated_at_formatted' => $this->updated_at_formatted,
      'updated_at_human' => $this->updated_at_human,
      'updated_at_timestamp'=>$this->updated_at_timestamp
    ];
    }
}
