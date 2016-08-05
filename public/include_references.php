<?php
/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 08/03/2016                                                                 */
/* Last modified on 08/03/2016                                                           */
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
?>
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<script src="js/jquery-1.12.4.min.js"></script>
<script src="js/jquery-ui-1.12.0.min.js"></script>
<script src="js/main.js"></script>
<link href="css/jquery-ui-1.12.0.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<?php
/* Getting the current file's name without the extension and checking whether
 * there is are css and js files with the same name. If there are, they are included.
 */
$name = basename(filter_input(INPUT_SERVER, 'SCRIPT_FILENAME'), '.php');

$cssFileName = "css/" . $name . ".css";
$cssFilePath = PUBLIC_PATH . $cssFileName;
if (file_exists($cssFilePath)) {
    echo "<link href='$cssFileName' rel='stylesheet'/>";
}

$jsFileName = "js/" . $name . ".js";
$jsFilePath = PUBLIC_PATH . $jsFileName;
if (file_exists($jsFilePath)) {
    echo "<script type='text/javascript' src='$jsFileName'></script>";
}
?>