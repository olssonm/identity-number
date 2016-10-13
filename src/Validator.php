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

    public function isValid($number)
    {
        $formatter = new IdentityNumberFormatter($number, 10, false);
        $value = $formatter->getFormatted();

        switch ($this->type) {
            case Validator::IDENTITYNUMBER:
                return $this->validate($value, true);
                break;

            case Validator::ORGANISATIONNUMBER:
                return $this->validate($value, false);
                break;

            case Validator::COORDINATIONNUMBER:
                $value = $this->formatCoordination($value);
                return $this->validate($value, true);
                break;
        }

        return false;
    }

    private function validate($value, $checkDate)
    {
        // Perform simple test on invalid numbers
        if(in_array($value, $this->invalidNumbers)) {
            return false;
        }

        // If checking for a date
        if ($checkDate == true) {
            $dateTest = substr($value, 0, 6);
            $validDate = $this->validDate($dateTest);
            if ($validDate == false) {
                return false;
            }
        }

        // Check luhn
        return $this->luhn($value);
    }

    private function luhn($value)
    {
        settype($value, 'string');
        $value = array_reverse(str_split($value));
        $sum = 0;
        foreach($value as $key => $value){
            if($key % 2)
            $value = $value * 2;
            $sum += ($value >= 10 ? $value - 9 : $value);
        }
        return ($sum % 10 === 0);
    }

    private function formatCoordination($value)
    {
        // Retrieve the last to digits of the birthday
        $birthday = (int)substr($value, 4, 2);
        $birthday = substr_replace($value, ($birthday - 60), 4, 2);

        return $birthday;
    }

    /**
     * Validate a date as a format
     * @param  string $dateTestStr the date to be tested
     * @param  string $format      the date format
     * @return boolean             if the test passes
     */
    private function validDate($dateTestStr, $format = 'ymd')
    {
        $date = DateTime::createFromFormat('ymd', $dateTestStr);
        return $date && $date->format($format) == $dateTestStr;
    }
}
