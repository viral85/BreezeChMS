<?php

namespace App\Helpers;

Class Helpers
{
    public static function status()
    {
        $status = array('1' => 'Active', '2' => 'Inactive');
        return $status;
    }
}

?>