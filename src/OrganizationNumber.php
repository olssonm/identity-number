<?php namespace Olssonm\IdentityNumber;

use DateTime;

class OrganizationNumber extends Validator
{
    public function __construct()
    {
        $this->type = Validator::ORGANIZATIONNUMBER;
    }
}
