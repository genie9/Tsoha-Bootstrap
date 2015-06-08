<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function string_notempty_validator($string) {
        $errors = '';
        if ($string == NULL || $string == '') {
            $errors = 'Kenttä ei saa olla tyhjä';
        }
        return $errors;
    }

    public function string_length_validator($string, $length) {
        $errors = '';
        if (strlen($string) < $length) {
            $errors = 'Kentän syötteen pituus väintään ' . $length . " merkkiä";
        }
        return $errors;
    }

    public function year_validator($string) {
        $errors = '';
        if (!preg_match("/^[12][09][0-9]{2}$/", $string)) {
            $errors = 'Tarkista vuosiluku';
        }
        return $errors;
    }

    public function date_validator($string) {
        $errors = '';
        if (!preg_match("/^[0-9]{1,2}.[0-9]{1,2}.[0-9]{2,4}$/", $string)) {
            $errors = 'Tarkista päivämäärä';
        } else {
            list($day, $month, $year) = explode(".", $string);
            if (!checkdate($month, $day, $year) && $year) {
                $errors = 'Tarkista päivämäärä';
            }
        }
        return $errors;
    }

    public function functionName($type) {
        $errors = "";
        if ($type === 'puhelin' && preg_match("/\D/", $string)) {
            $errors .= 'Tarkista puhelinnumero';
        }

        if ($type === 'aika' && !preg_match("/^([0-2]?[0-9])(:|.)([0-2][0-9])$/", $string)) {
            $errors .= 'Tarkista kellonaika';
        }

        return $errors;
    }

    public function errors() {
        $errors = array();

        foreach ($this->validators as $validator) {
            $validator_errors = $this->{$validator}();

            foreach ($validator_errors as $validator_error) {
                if ($validator_error != '') {
                    $errors[] = $validator_error;
                }
            }
        }
        return $errors;
    }

}
