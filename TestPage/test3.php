<?php

    function is_contactno_invalid($contactno) {
        $valid_number = filter_var($contactno, FILTER_SANITIZE_NUMBER_INT);
        if (preg_match('/^[0-9]{11}+$/', $valid_number)) {
            echo 'Valid Number: ' . $valid_number . '<br>';
        } else {
            echo 'Invalid Number: ' . $valid_number . '<br>';
        }
    }
    is_contactno_invalid("09499856978");
    is_contactno_invalid('0949 9856 978');
    is_contactno_invalid('+6499856978');
    is_contactno_invalid('$6499856978');
?>