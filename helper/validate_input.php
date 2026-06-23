<?php
function validatePhone(string $phone)
{
    if (preg_match("/^[0-9]{10,11}$/", $phone)) {
        return true;
    }

    return false;
}

function validateIcNumber(string $icNumber)
{
    if (preg_match("/^[0-9]{12}$/", $icNumber)) {
        return true;
    }

    return false;
}
?>