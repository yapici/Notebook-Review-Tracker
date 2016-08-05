<?php
/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 08/03/2016                                                                 */
/* Last modified on 08/04/2016                                                           */
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

define("ROOT", dirname(filter_input(INPUT_SERVER, 'DOCUMENT_ROOT')));
define("PRIVATE_PATH", ROOT . "/private/");
define("PUBLIC_PATH", ROOT . "/public/");
define("BUILD_PATH", ROOT . "/build/");
define("CLASSES_PATH", PRIVATE_PATH . 'include/classes/');

// Setting the timezone to CDT
date_default_timezone_set('America/Chicago');

// Including all the class files under CLASSES_PATH
foreach (glob(CLASSES_PATH . '*.php') as $file) {
    include($file);
}

// Initializing the PDO Database ($Database)
require_once(PRIVATE_PATH . "include/database.php");

// Initializing all the required classes
require_once(PRIVATE_PATH . "include/init_classes.php");

// Including the automatic build number increase functions
require_once(BUILD_PATH . "build.php");
?>