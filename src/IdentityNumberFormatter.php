<?php namespace Olssonm\IdentityNumber;

class IdentityNumberFormatter
{

    /**
     * Set value
     * @var string
     */
    private $value;

    /**
     * Number of characters
     * @var integer
     */
    private $characters;

    /**
     * If hyphens is allowed
     * @var boolean
     */
    private $useHyphen;

    /**
     * What type of hyphen to use ("-"/+)
     * @var string
     */
    private $typeHyphen = '-';

    /**
     * Format the personal identity number to make validation easier
     * @param  string   $value          the input value
     * @param  int      $characters     number of characters
     * @param  bool     $useHyphen      if hyphens should be used
     * @return void
     */
    public function __construct($value, $characters, $useHyphen = false)
    {
        $this->value = $value;
        $this->characters = $characters;
        $this->useHyphen = $useHyphen;
    }

    /**
     * Retrieve the formatted personal identity number
     * @return string   the personal identity number
     */
    public function getFormatted()
    {
        $value = $this->value;
        $characters = $this->characters;
        $useHyphen = $this->useHyphen;

        // Check if "+" is present, then use it as a hyphen
        if (strpos($value, '+') !== false) {
            $this->typeHyphen = '+';
        }

        // Remove hyphen
        $value = str_replace(['-', '+'], '', $value);

        if(strlen($value) != 12 && strlen($value) != 10) {
            return false;
        }

        if($characters == 12 && strlen($value) == 10) {
            $value = 19 . $value;
        }

        if($characters == 10 && strlen($value) == 12) {
            $newNumber = null;
            for ($i=0; $i < strlen($value); $i++) {
                if($i > 1) {
                    $newNumber .= $value[$i];
                }
            }
            $value = $newNumber;
        }

        // Insert hyphen if you need to
        if($useHyphen == true) {
            $newNumber = null;
            for ($i=0; $i < strlen($value); $i++) {
                $newNumber .= $value[$i];
                if($i == strlen($value) - 5) {
                    $newNumber .= $this->typeHyphen;
                }
            }
            $value = $newNumber;
        }

        return $value;
    }
}
