<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 08/27/2016                                                                 */
/* Last modified on 08/27/2016                                                           */
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

class Comments {

    private $Database;
    private $Functions;

    /** @var array $commentsArray */
    public $commentsArray;

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
        $sql = sprintf("SELECT c.id, c.notebook_id, c.sender_id, c.datetime, c.comment, u.username FROM comments c JOIN %s.users u ON (c.sender_id = u.id)", Constants::OMS_DB_NAME);
        $stmt = $this->Database->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sanitizedArray = $this->Functions->sanitizeArray($row);
            $this->commentsArray[$sanitizedArray['notebook_id']][$sanitizedArray['id']] = $sanitizedArray;
        }
    }

    public function refreshArray() {
        $this->populateArray();
    }

    /**
     * @return array $commentsArray
     */
    public function getCommentsArray() {
        return $this->commentsArray;
    }

    /**
     * @param string $notebookId
     * @return array An array of comments for the provided notebook id
     */
    public function getCommentsWithId($notebookId) {
        return $this->commentsArray[$notebookId];
    }

    /**
     * @param string $notebookId
     * @param string $comment
     * @param string $senderId
     * @return boolean Result of the PDO SQL statement execution. Returns true if successful.
     */
    public function addComment($notebookId, $comment, $senderId) {
        $sql = sprintf("INSERT INTO comments (notebook_id, sender_id, comment) VALUES (:notebookId, :senderId, :comment)");
        $stmt = $this->Database->prepare($sql);
        $stmt->bindValue(':notebookId', $notebookId, PDO::PARAM_STR);
        $stmt->bindValue(':senderId', $senderId, PDO::PARAM_STR);
        $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
        return $stmt->execute();
    }

}

?>