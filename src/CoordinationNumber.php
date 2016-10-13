<?php namespace Olssonm\IdentityNumber;

use DateTime;

class CoordinationNumber extends Validator
{
    public function __construct()
    {
        $this->type = Validator::COORDINATIONNUMBER;
        parent::__construct();
    }
}
