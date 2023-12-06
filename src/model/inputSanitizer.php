<?php

class InputSanitizer
{
    public function sanitize($input)
    {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
}
