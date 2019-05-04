<?php

namespace App;

use App\Exceptions\NotEnoughNumbersException;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Number.
 *
 * @package App
 */
class Number extends Model
{
    protected $guarded = [];

    /**
     * Add numbers.
     *
     * @param $quantity
     */
    public static function addNumbers($quantity,$session) {
        $initial = Number::last($session) ? Number::last() + 1 : 1;
        foreach (range($initial, $initial + $quantity -1 ) as $value) {
            Number::create([
                'value' => $value,
                'session' => $session
            ]);
        }
    }

    /**
     * Numbers.
     *
     */
    public static function numbers() {
        return map_collection(Number::with('user')->get());
    }

    /**
     * currentNumbers.
     *
     */
    public static function currentNumbers() {
        return map_collection(Number::with('user')->where('session', config('lanparty.session'))->get());
    }

    /**
     * Get first available number.
     *
     * @return mixed
     */
    public static function firstAvailableNumber($session) {
        return Number::available()->where('session',$session)->orderBy('value', 'asc')->first();
    }

    /**
     * Available scope.
     *
     * @param $query
     * @return mixed
     */
    public function scopeAvailable($query)
    {
        return $query->where('user_id', null);
    }

    /**
     * Assigned scope.
     *
     * @param $query
     * @return mixed
     */
    public function scopeAssigned($query)
    {
        return $query->whereNotNull('user_id');
    }

    /**
     * Obtain last number
     *
     * @return mixed
     */
    public static function last($session) {
        $lastNumber = Number::where('session', $session)->orderBy('value', 'desc')->first();
        return $lastNumber ? (int) $lastNumber->value : null;
    }

    /**
     * Assign user.
     *
     * @param $user
     * @param string $description
     * @return $this
     */
    public function assignUser($user, $description = '')
    {
        $this->user()->associate($user);
        $this->description = $description;
        $this->save();
        return $this;
    }

    /**
     * Get the user record associated with the number.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * full_search attribute.
     *
     * @return mixed
     */
    public function getFullSearchAttribute()
    {
        if ($this->user_id) {
            return $this->value . ' ' . $this->description . ' ' . $this->user->givenName . ' ' . $this->user->sn1 . ' ' .
                $this->user->sn2 . ' ' . $this->user->name;
        }
        return "$this->value $this->description";
    }

    /**
     * Map.
     *
     * @return array
     */
    public function map()
    {
        $number = [
            'id' => $this->id,
            'value' => $this->value,
            'session' => $this->session,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
            'full_search' => $this->full_search
        ];
        if ( $this->user) {
            $number = array_merge($number, [
                'user' => [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'sn1' => $this->user->sn1,
                    'sn2' => $this->user->sn2,
                    'givenName' => $this->user->givenName,
                    'email' => $this->user->email,
                ]
            ]);
        }
        return $number;
    }

    /**
     * Add numbers.
     *
     * @param $quantity
     */
    public static function removeNumbers($quantity, $session) {
        foreach (range(1, $quantity ) as $value) {
            $number = Number::firstAvailableNumber($session);
            if (!$number) throw new NotEnoughNumbersException();
            $number->delete();
        }
    }
}
