<?php

class InputSanitizer
{
    public static function sanitize($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
}
