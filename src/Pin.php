<?php

namespace Olssonm\IdentityNumber;

/**
 * Static helper-class for accessing the validation methods statically
 */
class Pin
{
    /**
     * Main method used for validation, acts as a static helper
     *
     * @param  string  $number the number
     * @param  string  $type   what type of validator to use
     * @return boolean
     */
    public static function isValid($number, $type = 'identity')
    {
        switch ($type) {
            case 'identity':
                $validator = new IdentityNumber();
                return $validator->isValid($number);
                break;

            case 'organization':
                $validator = new OrganizationNumber();
                return $validator->isValid($number);
                break;

            case 'coordination':
                $validator = new CoordinationNumber();
                return $validator->isValid($number);
                break;
        }

        return false;
    }
}
