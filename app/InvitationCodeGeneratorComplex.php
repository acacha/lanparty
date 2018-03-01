<?php

namespace App;

/**
 * Class InvitationCodeGeneratorComplex.
 *
 * @package App
 */
class InvitationCodeGeneratorComplex implements InvitationCodeGenerator
{
    /**
     * Generate random number.
     *
     * @return bool|string
     */
    public function generate()
    {
        $pool = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

        return substr(str_shuffle(str_repeat($pool, 24)), 0, 24);
    }
}