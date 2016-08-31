<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 08/04/2016                                                                 */
/* Last modified on 08/31/2016                                                           */
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

class Functions {

    /** @param array $array 
     *  @return array $sanitizedArray
     */
    public function sanitizeArray($array) {
        $sanitizedArray = array();
        foreach ($array as $key => $value) {
            $sanitizedArray[$key] = htmlspecialchars(trim($value));
        }
        return $sanitizedArray;
    }

    /* ################################# -- Date Conversion Functions -- ################################## */
    /* #################################################################################################### */

    public function convertMysqlDateToPhpDate($date) {
        if ($date == "0000-00-00" || $date == "0000-00-00 00:00:00") {
            $date = "N/A";
        } else {
            $date = date('d-M-Y', strtotime($date));
        }
        return $date;
    }

    /** @param string $date
     *  @return string $convertedDate
     */
    public function convertStrDateToMysqlDate($date) {
        $slashesReplacedDate = str_replace("/", "-", $date);
        try {
            $convertedDate = date('Y-m-d', strtotime($slashesReplacedDate));
            if ($convertedDate == "1970-01-01" || $convertedDate == "1969-12-31") {
                $convertedDate = date('Y-m-d', strtotime(preg_replace("/(\d+)\D+(\d+)\D+(\d+)/", "$3-$2-$1", $date)));
                if ($convertedDate == "1970-01-01" || $convertedDate == "1969-12-31") {
                    $dashesReplacedDate = str_replace("-", "/", $date);
                    $convertedDate = date('Y-m-d', strtotime($dashesReplacedDate));
                }
            }
        } catch (Exception $e) {
            $convertedDate = "0";
        }
        return $convertedDate;
    }
    public function convertMysqlDateToDateTime($date) {
        if ($date == "0000-00-00" || $date == "0000-00-00 00:00:00") {
            $date = "N/A";
        } else {
            $date = date('d-M-Y g:i a', strtotime($date));
        }
        return $date;
    }

    /* /  ************************************************************************************************* */
    /* /  ****************************** -- Date Conversion Functions -- ********************************** */



    /* #################################### -- Redirect Functions -- ###################################### */
    /* #################################################################################################### */

    public function phpRedirect($target) {
        header("Location: /$target");
        exit;
    }

    public function jsRedirect($target) {
        $script = '<script type="text/javascript">';
        $script .= 'window.location = "' . $target . '"';
        $script .= '</script>';

        echo $script;
    }

    /* /  ************************************************************************************************* */
    /* /  ********************************* -- Redirect Functions -- ************************************** */

    public function getDomainFromEmail($email) {
        $domain = substr(strrchr($email, "@"), 1);
        return $domain;
    }

    // This function is used in 'public/ajax/add-new-item-action.php'.
    /** @return array $sanitizedArray
     */
    public function sanitizePostedVariables() {
        $sanitizedArray = array();
        foreach ($_POST as $key => $value) {
            $sanitizedArray[$key] = htmlspecialchars(trim(filter_input(INPUT_POST, $key)));
        }
        return $sanitizedArray;
    }

    /**
     *  @param string $title
     *  @param string or array $error_msg
     */
    public function logError($title, $error_msg) {
        error_log("\n$title\n", 3, "php.log");
        if (is_array($error_msg)) {
            error_log(print_R($error_msg,TRUE), 3, "php.log");
        } else {
            error_log($error_msg, 3, "php.log");
        }
        error_log("\n$title\n", 3, "php.log");
    }

}

?>
