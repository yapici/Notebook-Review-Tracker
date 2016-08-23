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

require_once('../private/include/include.php');

if ($Session->isSessionValid()) {
    $Functions->phpRedirect('home');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    <head>
        <title>Notebook Review Tracker</title>
        <?php
        require_once ('include_references.php');
        ?>
    </head>

    <body>
        <div id="gray-out-div"></div>
        <img id="progress-bar" src="images/progress-bar.gif"/>
        <?php require_once (PRIVATE_PATH . 'require/header.php'); ?>      
        <div id="login-main-body-wrapper">
            <h1>Log In</h1>
            <div><input id="email" type="text" placeholder="E-mail Address" maxlength="111"/></div>
            <div><input id="password" type="password" placeholder="Password"/></div>
            <div><a class="button" onclick="Login.loginUser()">Submit</a></div>
        </div>
        <div><a class='text-only-button' href="/register">Don't have an account? Register here</a></div>
        <div><a class='text-only-button' href="/forgot-password">Forgot password?</a></div>
        <div class="error-div" id="login-error-div"></div>
    </body>
</html>

