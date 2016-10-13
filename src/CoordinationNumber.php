<?php namespace Olssonm\IdentityNumber;

use DateTime;

class CoordinationNumber extends Validator
{
    public function __construct()
    {
        $this->type = Validator::COORDINATIONNUMBER;
        parent::__construct();
    }

    public function isValid($number)
    {
        $number = $this->formatNumber($number);
        $number = $this->formatCoordination($number);
        return parent::isValid($number);
    }

    private function formatCoordination($value)
    {
        // Retrieve the last to digits of the birthday
        $birthday = (int)substr($value, 4, 2);
        $birthday = substr_replace($value, ($birthday - 60), 4, 2);

        return $birthday;
    }
}
