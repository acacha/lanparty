<?php
/**
 * Created by PhpStorm.
 * User: alumne
 * Date: 11/05/19
 * Time: 4:26
 */

namespace App\Http\Requests\Partners;


use Illuminate\Foundation\Http\FormRequest;

class AvatarStore extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'avatar' => 'required'
    ];
  }
}
