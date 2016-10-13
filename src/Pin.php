<?php namespace Olssonm\IdentityNumber;

/**
 * Static helper-class for accessing the validation methods statically
 */
class Pin
{
    public static function isValid($number, $type = 'identity')
    {
        switch ($type) {
            case 'identity':
                $validator = new IdentityNumber();
                return $validator->isValid($number);
                break;

            case 'organisation':
                $validator = new OrganisationNumber();
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
