<?php namespace Olssonm\IdentityNumber;

use DateTime;

class Validator
{
    const IDENTITYNUMBER = 'personal_identity_number';

    const ORGANISATIONNUMBER = 'organisation_number';

    const COORDINATIONNUMBER = 'coordination_number';

    protected $type;

    protected $invalidNumbers = [
        '0000000000',
        '2222222222',
        '4444444444',
        '5555555555',
        '7777777777',
        '9999999999'
    ];

    public function __construct() {}

    /**
     * Main validation method
     * @param  string  $number the number under validation
     * @return boolean
     */
    public function isValid($number)
    {
        switch ($this->type) {
            case Validator::IDENTITYNUMBER:
                $number = $this->formatNumber($number);
                return $this->validate($number, true);
                break;

            case Validator::ORGANISATIONNUMBER:
                $number = $this->formatNumber($number);
                return $this->validate($number, false);
                break;

            case Validator::COORDINATIONNUMBER:
                return $this->validate($number, true);
                break;
        }

        return false;
    }

    /**
     * Internal validator
     * @param  string   $number     the value under validation
     * @param  boolean  $checkDate if date validation is to be performed
     * @return boolean
     */
    private function validate($number, $checkDate)
    {
        // Perform simple test on invalid numbers
        if(in_array($number, $this->invalidNumbers)) {
            return false;
        }

        // If checking for a date
        if ($checkDate == true) {
            $dateTest = substr($number, 0, 6);
            $validDate = $this->validDate($dateTest);
            if ($validDate == false) {
                return false;
            }
        }

        // Check luhn
        return $this->luhn($number);
    }

    protected function formatNumber($number)
    {
        $formatter = new IdentityNumberFormatter($number, 10, false);
        $value = $formatter->getFormatted();

        return $value;
    }

    /**
     * Perform luhn validation
     * @param  string $number
     * @return boolean
     */
    private function luhn($number)
    {
        settype($number, 'string');
        $number = array_reverse(str_split($number));
        $sum = 0;
        foreach($number as $key => $number){
            if($key % 2)
            $number = $number * 2;
            $sum += ($number >= 10 ? $number - 9 : $number);
        }
        return ($sum % 10 === 0);
    }

    /**
     * Validate a date as a format
     * @param  string $dateTest     the date to be tested
     * @param  string $format       the date format
     * @return boolean
     */
    private function validDate($dateTest, $format = 'ymd')
    {
        $date = DateTime::createFromFormat('ymd', $dateTest);
        return $date && $date->format($format) == $dateTest;
    }
}
