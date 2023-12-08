<?php

class Session
{
    public function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function end()
    {
        session_unset();
        session_destroy();
    }

    public function isStarted()
    {
        if (session_status() == PHP_SESSION_ACTIVE){
            return false;
        } else {
            return true;
        }
    }
}
