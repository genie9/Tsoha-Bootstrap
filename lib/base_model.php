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

    public function string_notempty_validator($string, $field_name) {
        $errors = '';
        if ($string == NULL || $string == '') {
            $errors = $field_name . ' kenttä ei saa olla tyhjä';
        }
        return $errors;
    }

    public function string_length_validator($string, $length, $field_name) {
        $errors = '';
        if (strlen($string) < $length) {
            $errors = $field_name . ' kentän syötteen pituus väintään ' . $length . " merkkiä, pituus oli " . strlen($string) . " merkkiä.";
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
        $year_now = date('Y');
        $errors = '';
        if (preg_match("/^[0-9]{1,2}.[0-9]{1,2}.[0-9]{2,4}$/", $string)) {
            list($day, $month, $year) = explode(".", $string);
        } else if (preg_match("/^[0-9]{4}.[0-9]{2}.[0-9]{2}$/", $string)) {
            list($year, $month, $day) = explode("-", $string);
        } else {
            $errors = 'Tarkista päivämäärä eka testi fail';
            return $errors;
        }
        if (!checkdate($month, $day, $year) || $year < 1900 || $year > $year_now) {
            $errors = 'Tarkista päivämäärä KOLMAS testi fail';
        }
        return $errors;
    }

    public function function_NotInUse($string) {
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
