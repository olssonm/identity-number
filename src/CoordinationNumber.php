<?php namespace Olssonm\IdentityNumber;

use DateTime;

class CoordinationNumber extends Validator
{
    public function __construct()
    {
        $this->type = Validator::COORDINATIONNUMBER;
        parent::__construct();
    }

    /**
     * Overload the Validtor@isValid-method
     *
     * @NOTE The number has to be formatted before using the
     * formatCoordination-method
     * @param  string  $number the number
     * @return boolean         [description]
     */
    public function isValid($number)
    {
        $number = $this->formatNumber($number);
        $number = $this->formatCoordination($number);
        return parent::isValid($number);
    }

    /**
     * Format the coordination number (add/remove 60 from the birthday)
     * @param  string $value the date/number
     * @return boolean
     */
    private function formatCoordination($value)
    {
        // Retrieve the last to digits of the birthday
        $birthday = (int)substr($value, 4, 2);
        $birthday = substr_replace($value, ($birthday - 60), 4, 2);

        return $birthday;
    }
}
