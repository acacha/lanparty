<?php

namespace App\Traits;

use Illuminate\Support\Str;

/**
 * Class ApiURI.
 *
 * @package App\Traits
 */
trait ApiURI
{
    /**
     * formatted_created_at_date attribute.
     *
     * @return mixed
     */
    public function getApiURIAttribute()
    {
        return strtolower(Str::snake(Str::plural(class_basename($this))));
    }

}
