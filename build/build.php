<?php
/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 08/03/2016                                                                 */
/* Last modified on 08/03/2016                                                            */
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

// Opening the json file that holds the file paths and file modification dates
$string = file_get_contents(BUILD_PATH . 'files.json');
$jsonArray = json_decode($string, true);

// Putting the values into a local array
$jsonFileArray = array();
foreach ($jsonArray as $filePath => $modifiedDate) {
    $jsonFileArray[$filePath] = $modifiedDate;
}

// Iterating through the directories and putting the file paths and modification dates into a local array
$filesArray = array();
$dir_iterator = new RecursiveDirectoryIterator(PUBLIC_PATH); // public directory
$recursive_iterator = new RecursiveIteratorIterator($dir_iterator);
foreach ($recursive_iterator as $file) {
    if ($file->isDir()) {
        continue;
    }
    if (substr($file, -7) != 'php.log' &&
            substr($file, -9) != 'error_log' &&
            substr($file, -9) != 'README.md') {
        $fileName = 'public/' . $file->getPathname();
        $fileModifiedDate = date('m/d/y H:i:s', $file->getMTime());
        $filesArray[$fileName] = $fileModifiedDate;
    }
}

$dir_iterator = new RecursiveDirectoryIterator(PRIVATE_PATH); // private directory
$recursive_iterator = new RecursiveIteratorIterator($dir_iterator);
foreach ($recursive_iterator as $file) {
    if ($file->isDir()) {
        continue;
    }
    if (!preg_match('/private\/attachments/', $file) &&
            substr($file, -7) != 'php.log' &&
            substr($file, -9) != 'error_log') {
        $fileName = $file->getPathname();
        $fileModifiedDate = date('m/d/y H:i:s', $file->getMTime());
        $filesArray[$fileName] = $fileModifiedDate;
    }
}

// Checking if there are any files that are modified/created/deleted
if ($jsonFileArray != $filesArray) {
    $file = BUILD_PATH . "build";
    file_put_contents($file, file_get_contents($file) + 1);
}

// Updating the json file with the latest modifiedDates
$jsonFile = fopen(BUILD_PATH . 'files.json', 'w');
fwrite($jsonFile, json_encode($filesArray, JSON_UNESCAPED_SLASHES));
fclose($jsonFile);
?>