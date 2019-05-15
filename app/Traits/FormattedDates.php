<?php

namespace App\Traits;

use Carbon\Carbon;

/**
 * Class FormattedDates.
 *
 * @package App\Traits
 */
trait FormattedDates
{
  /**
   * formatted_created_at_date attribute.
   *
   * @return mixed
   */
  public function getFormattedCreatedAtAttribute()
  {
    return optional($this->created_at)->format('h:i:sA d-m-Y');
  }

  /**
   * created_at_timestamp attribute.
   *
   * @return mixed
   */
  public function getCreatedAtTimestampAttribute()
  {
    return optional($this->created_at)->timestamp;
  }

  /**
   * created_at_timestamp attribute.
   *
   * @return mixed
   */
  public function getUpdatedAtTimestampAttribute()
  {
    return optional($this->updated_at)->timestamp;
  }

  /**
   * published_at_timestamp attribute.
   *
   * @return mixed
   */
  public function getPublishedAtTimestampAttribute()
  {
    return optional($this->published_at)->timestamp;
  }

  /**
   * deleted_at_timestamp attribute.
   *
   * @return mixed
   */
  public function getDeletedAtTimestampAttribute()
  {
    return optional($this->deleted_at)->timestamp;
  }

  /**
   * formatted_updated_at_date attribute.
   *
   * @return mixed
   */
  public function getFormattedUpdatedAtAttribute()
  {
    return optional($this->updated_at)->format('h:i:sA d-m-Y');
  }

  /**
   * formatted_published_at_date attribute.
   *
   * @return mixed
   */
  public function getFormattedPublishedAtAttribute()
  {
    return optional($this->published_at)->format('h:i:sA d-m-Y');
  }

  /**
   * formatted_deleted_at_date attribute.
   *
   * @return mixed
   */
  public function getFormattedDeletedAtAttribute()
  {
    return optional($this->deleted_at)->format('h:i:sA d-m-Y');
  }

  /**
   * formatted_created_at_date_diff attribute.
   *
   * @return mixed
   */
  public function getFormattedCreatedAtDiffAttribute()
  {
    Carbon::setLocale(config('app.locale'));
    return optional($this->created_at)->diffForHumans(Carbon::now());
  }

  /**
   * formatted_updated_at_date_diff attribute.
   *
   * @return mixed
   */
  public function getFormattedUpdatedAtDiffAttribute()
  {
    Carbon::setLocale(config('app.locale'));
    return optional($this->updated_at)->diffForHumans(Carbon::now());
  }

  /**
   * formatted_published_at_date_diff attribute.
   *
   * @return mixed
   */
  public function getFormattedPublishedAtDiffAttribute()
  {
    Carbon::setLocale(config('app.locale'));
    return optional($this->published_at)->diffForHumans(Carbon::now());
  }

  /**
   * formatted_published_at_date_diff attribute.
   *
   * @return mixed
   */
  public function getFormattedDeletedAtDiffAttribute()
  {
    Carbon::setLocale(config('app.locale'));
    return optional($this->deleted_at)->diffForHumans(Carbon::now());
  }

}
