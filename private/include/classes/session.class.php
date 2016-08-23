<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 08/22/2016                                                                 */
/* Last modified on 08/22/2016                                                           */
/* ===================================================================================== */

/* ===================================================================================== */
/* The MIT License                                                                       */
/*                                                                                       */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>.                                 */
/*                                                                                       */
/* Permission is hereby granted, free of charge, to any person obtaining a copy          */
/* of this software and associated documentation files (the "Software"), to deal         */
/* in the Software without restriction, including without limitation the rights          */
/* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell             */
/* copies of the Software, and to permit persons to whom the Software is                 */
/* furnished to do so, subject to the following conditions:                              */
/*                                                                                       */
/* The above copyright notice and this permission notice shall be included in            */
/* all copies or substantial portions of the Software.                                   */
/*                                                                                       */
/* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR            */
/* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,              */
/* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE           */
/* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER                */
/* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,         */
/* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN             */
/* THE SOFTWARE.                                                                         */
/* ===================================================================================== */

class Session {
    
    function __construct() {
        session_start();
    }

    function endSession() {
        session_unset();
        session_destroy();
    }

    function requestIpMatchesSession() {
        if (!isset($_SESSION['ip']) || !isset($_SERVER['REMOTE_ADDR'])) {
            return false;
        }
        if ($_SESSION['ip'] === $_SERVER['REMOTE_ADDR']) {
            return true;
        } else {
            return false;
        }
    }
    
    function requestUserAgentMatchesSession() {
        if (!isset($_SESSION['user_agent']) || !isset($_SERVER['HTTP_USER_AGENT'])) {
            return false;
        }
        if ($_SESSION['user_agent'] === $_SERVER['HTTP_USER_AGENT']) {
            return true;
        } else {
            return false;
        }
    }

    function lastLoginIsRecent() {
        $maxElapsed = 24 * 60 * 60; // 1 day
        if (!isset($_SESSION['last_login'])) {
            $this->afterSuccessfulLogout();
            return false;
        }
        if (($_SESSION['last_login'] + $maxElapsed) >= time()) {
            $_SESSION['last_login'] = time();
            return true;
        } else {
            $this->afterSuccessfulLogout();
            return false;
        }
    }

    function isSessionValid() {
        $checkIp = true;
        $checkUserAgent = true;
        $checkLastLogin = true;

        if ($checkIp && !$this->requestIpMatchesSession()) {
            return false;
        }
        if ($checkUserAgent && !$this->requestUserAgentMatchesSession()) {
            return false;
        }
        if ($checkLastLogin && !$this->lastLoginIsRecent()) {
            return false;
        }
        return true;
    }

    function isLoggedIn() {
        return (isset($_SESSION['logged_in']) && $_SESSION['logged_in']);
    }

    function afterSuccessfulLogin() {
        session_regenerate_id();

        $_SESSION['logged_in'] = true;

        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['last_login'] = time();
    }

    function afterSuccessfulLogout() {
        $_SESSION['logged_in'] = false;
        $this->endSession();
    }
}
?>