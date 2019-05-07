<?php

namespace App;

use App\Traits\FormattedDates;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Prize.
 *
 * @package App
 */
class Prize extends Model
{
    use FormattedDates;
    protected $guarded = [];

    public static function prizes()
    {
        return map_collection(Prize::all());
    }


    /**
     * Get the partner that owns the prize.
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * Get the user that owns the prize.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the number that owns the prize.
     */
    public function number()
    {
        return $this->belongsTo(Number::class);
    }

    /**
     * Scope a query to only include available prizes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->where('session', config('lanparty.session',2019))->where('user_id', null)->where('number_id', null);
    }

    /**
     * Winners scope.
     *
     * @param $query
     * @return mixed
     */
    public function scopeWinners($query)
    {
        return $query->where('number_id','!=', null);
    }

    public function map()   {
        return [
          'id' => $this->id,
          'name'=> $this->name,
          'description' => $this->description,
          'session' => $this->session,
          'notes' => $this->notes,
          'value' => $this->value,
          'partner_id'=>$this->partner_id,
          'user_id' =>$this->user_id,
          'number_id' => $this->number_id,
          'multiple' => $this->multiple,
          'created_at' => $this->created_at,
          'created_at_formatted' => $this->created_at_formatted,
          'created_at_human' => $this->created_at_human,
          'updated_at' => $this->updated_at,
          'updated_at_formatted' => $this->updated_at_formatted,
          'updated_at_human' => $this->updated_at_human
        ];
    }
}
