<?php
/**
 * Created by PhpStorm.
 * User: sergi
 * Date: 23/02/18
 * Time: 17:06
 */

namespace App;

/**
 * Class InvitationCodeGeneratorSimple
 * 
 * @package App
 */
class InvitationCodeGeneratorSimple implements InvitationCodeGenerator
{
    /**
     * @return string
     */
    public function generate()
    {
        return 'INVITATIONCODE_123';
    }
}