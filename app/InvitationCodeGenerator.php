<?php


namespace App;

/**
 * Class InvitationCodeGenerator.
 *
 * @package App
 */
interface InvitationCodeGenerator
{
    /**
     * @return string
     */
    public function generate();
}