<?php namespace Olssonm\IdentityNumber;

use DateTime;

class OrganisationNumber extends Validator
{
    public function __construct()
    {
        $this->type = Validator::ORGANISATIONNUMBER;
    }
}
