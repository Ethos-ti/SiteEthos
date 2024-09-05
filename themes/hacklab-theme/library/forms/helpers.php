<?php

namespace hacklabr;

/**
 * Validate a CNPJ number.
 *
 * @param string $cnpj The CNPJ number to validate.
 * @return bool True if the CNPJ number is valid, false otherwise.
 */
function validate_cnpj($cnpj) {
    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

    if (strlen($cnpj) != 14) {
        return false;
    }

    if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
        return false;
    }

    $calculate_dv = function($cnpj, $digits) {
        $sum = 0;
        $weight = $digits;
        for ($i = 0; $i < strlen($cnpj); $i++) {
            $sum += $cnpj[$i] * $weight--;
            if ($weight < 2) {
                $weight = 9;
            }
        }
        $remainder = $sum % 11;
        return $remainder < 2 ? 0 : 11 - $remainder;
    };

    $dv1 = $calculate_dv(substr($cnpj, 0, 12), 5);
    $dv2 = $calculate_dv(substr($cnpj, 0, 13), 6);

    return $dv1 == $cnpj[12] && $dv2 == $cnpj[13];
}
