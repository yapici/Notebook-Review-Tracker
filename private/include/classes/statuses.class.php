<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 08/05/2016                                                                 */
/* Last modified on 08/21/2016                                                           */
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

class Statuses {

    private $Database;
    private $Functions;

    /** @var array $usersArray */
    public $statusesArray;

    /**
     * @param Database $database
     * @param Functions $functions
     */
    function __construct($database, $functions) {
        $this->Database = $database;
        $this->Functions = $functions;
        $this->populateArray();
    }

    private function populateArray() {
        $sql = sprintf("SELECT s.id, s.status_name, s.created_by_user_id FROM status s JOIN %s.users u ON (s.created_by_user_id = u.id) WHERE s.deleted = 0", Constants::OMS_DB_NAME);
        $stmt = $this->Database->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sanitizedArray = $this->Functions->sanitizeArray($row);
            $this->statusesArray[$sanitizedArray['id']] = $sanitizedArray;
        }
    }

    public function refreshArray() {
        $this->populateArray();
    }

    /**
     * @return array $statusesArray
     */
    public function getStatusesArray() {
        return $this->statusesArray;
    }

    public function populateStatusesforTable($status) {
        $html = '';
        if (!empty($this->statusesArray)) {
            $html .= '<select>';
            foreach ($this->statusesArray as $statusId => $status) {
                $statusName = $status['status_name'];
                if ($statusName == $status) {
                    $html .= "<option selected value='$statusId'>$statusName</option>";
                } else {
                    $html .= "<option value='$statusId'>$statusName</option>";
                }
            }
            $html .= '</select>';
        } else {
            $html = $status;
        }
        return $html;
    }

}
?>