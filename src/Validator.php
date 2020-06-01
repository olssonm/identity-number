<?php

namespace Olssonm\IdentityNumber;

use DateTime;

/**
 * Main validation class
 */
class Validator
{
    const IDENTITYNUMBER = 'personal_identity_number';

    const ORGANIZATIONNUMBER = 'organization_number';

    const COORDINATIONNUMBER = 'coordination_number';

    /**
     * Current validation type
     *
     * @var string
     */
    protected $type;

    /**
     * Numbers that actually passes the Luhn-algorithm but
     * that are non-valid
     *
     * @var array
     */
    protected $invalidNumbers = [
        '0000000000',
        '2222222222',
        '4444444444',
        '5555555555',
        '7777777777',
        '9999999999'
    ];

    public function __construct()
    {
        //
    }

    /**
     * Main validation method
     *
     * @param  string  $number the number under validation
     * @return boolean
     */
    public function isValid($number)
    {
        $number = $this->formatNumber($number);

        if (!$number) {
            return false;
        }

        switch ($this->type) {
            case Validator::IDENTITYNUMBER:
                return $this->validate($number, true);
                break;

            case Validator::ORGANIZATIONNUMBER:
                return $this->validate($number, false);
                break;

            case Validator::COORDINATIONNUMBER:
                return $this->validate($number, false);
                break;
        }

        return false;
    }

    /**
     * Internal validator
     *
     * @param  string   $number     the value under validation
     * @param  boolean  $checkDate if date validation is to be performed
     * @return boolean
     */
    private function validate($number, $checkDate)
    {
        // Perform simple test on invalid numbers
        if (in_array($number, $this->invalidNumbers)) {
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

    /**
     * Run the IdentityNumberFormatter on the specified number
     *
     * @param  string $number
     * @return string
     */
    protected function formatNumber($number)
    {
        $formatter = new IdentityNumberFormatter($number, 10, false);
        $value = $formatter->getFormatted();

        return $value;
    }

    /**
     * Perform luhn validation
     *
     * @param  string $number
     * @return boolean
     */
    private function luhn($number)
    {
        settype($number, 'string');
        $number = array_reverse(str_split($number));
        $sum = 0;
        foreach ($number as $key => $number) {
            if (!is_numeric($number)) {
                return false;
            }
            if ($key % 2) {
                $number = $number * 2;
            }
            $sum += ($number >= 10 ? $number - 9 : $number);
        }
        return ($sum % 10 === 0);
    }

    /**
     * Validate a date as a format
     *
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
