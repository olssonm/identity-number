<?php namespace Olssonm\IdentityNumber;

class IdentityNumber
{
    /**
     * Validate identity number
     * @param  string  $value the identity number
     * @return boolean        if the validity is true/false
     */
    public static function isValid($value)
    {
        // Use the IdentityNumberFormatter to make the validation easier
        $IdentityNumberFormatter = new IdentityNumberFormatter($value, 10, false);
        $value = $IdentityNumberFormatter->getFormatted();

        // Check string length
        if (!preg_match("/^\d{10}$/", $value)) {
            return false;
        }

        // Check that the value is a date
        $dateTestStr = substr($value, 0, 6);
        if(\DateTime::createFromFormat('ymd', $dateTestStr) == false) {
            return false;
        }

        // Perform Luhn-test
        settype($value, 'string');
        $sumTable = array(
            array(0,1,2,3,4,5,6,7,8,9),
            array(0,2,4,6,8,1,3,5,7,9)
        );
        $sum = 0;
        $flip = 0;
        for ($i = strlen($value) - 1; $i >= 0; $i--) {
            $sum += $sumTable[$flip++ & 0x1][$value[$i]];
        }
        return ($sum % 10 === 0);
    }
}
