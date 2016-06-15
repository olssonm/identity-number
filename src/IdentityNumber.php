<?php namespace Olssonm\IdentityNumber;

use DateTime;

class IdentityNumber
{
    // "Special cases", these should never be allowed
    static protected $invalidNumbers = [
        '0000000000',
        '2222222222',
        '4444444444',
        '5555555555',
        '7777777777',
        '9999999999'
    ];

    /**
     * Validate identity number
     * @param  string  $value       the identity number
     * @param  boolean $checkDate   flag if the date should be validated
     * @return boolean              if the validity is true/false
     */
    public static function isValid($value, $checkDate = true)
    {
        // Use the IdentityNumberFormatter to make the validation easier
        $IdentityNumberFormatter = new IdentityNumberFormatter($value, 10, false);
        $value = $IdentityNumberFormatter->getFormatted();

        if(in_array($value, static::$invalidNumbers)) {
            return false;
        }

        // Check string length
        if (!preg_match("/^\d{10}$/", $value)) {
            return false;
        }

        // Check that the value is a date
        $dateTestStr = substr($value, 0, 6);
        $validDate = self::validateDate($dateTestStr);
        if ($checkDate == true && $validDate == false) {
            return false;
        }

        // Perform Luhn-test
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

    /**
     * Validate a date as a format
     * @param  string $dateTestStr the date to be tested
     * @param  string $format      the date format
     * @return boolean             if the test passes
     */
    private static function validateDate($dateTestStr, $format = 'ymd')
    {
        $date = DateTime::createFromFormat('ymd', $dateTestStr);
        return $date && $date->format($format) == $dateTestStr;
    }
}
