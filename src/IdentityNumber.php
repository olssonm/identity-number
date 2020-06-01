<?php

namespace Olssonm\IdentityNumber;

use DateTime;

class IdentityNumber extends Validator
{
    public function __construct()
    {
        $this->type = Validator::IDENTITYNUMBER;
    }
}
