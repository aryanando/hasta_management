<?php

function isAdmin()
{
    if (Session('user_data')->id == 1) {
        return true;
    } else {
        false;
    }
}

function isUnit($unit_id, $userData)
{
    if (count($userData->unit) > 0) {
        if ($userData->unit[0]->id == $unit_id) {
            return true;
        }
        return false;
    } else {
        false;
    }
}
