<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 08/05/2016                                                                 */
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

class Notebooks {

    private $Database;
    private $Functions;
    private $Statuses;

    /** @var array $usersArray */
    public $notebooksArray;

    /**
     * @param Database $database
     * @param Functions $functions
     * @param Statuses $statuses
     */
    function __construct($database, $functions, $statuses) {
        $this->Database = $database;
        $this->Functions = $functions;
        $this->Statuses = $statuses;
        $this->populateArray();
    }

    private function populateArray() {
        $query_string = "SELECT n.id, "
                . "n.notebook_no, "
                . "n.author_id, "
                . "n.reviewer_id, "
                . "n.status_id, "
                . "n.created_date, "
                . "n.comments, "
                . "u1.username AS author_username, "
                . "u2.username AS reviewer_username, "
                . "s.status_name "
                . "FROM notebooks AS n "
                . "JOIN %s.users AS u1 ON (n.author_id = u1.id) "
                . "JOIN %s.users AS u2 ON (n.reviewer_id = u2.id) "
                . "JOIN status s ON (n.status_id = s.id)";

        $sql = sprintf($query_string, Constants::OMS_DB_NAME, Constants::OMS_DB_NAME);
        $stmt = $this->Database->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sanitizedArray = $this->Functions->sanitizeArray($row);
            $this->notebooksArray[$sanitizedArray['id']] = $sanitizedArray;
        }
    }

    public function refreshArray() {
        $this->populateArray();
    }

    /**
     * @return array $notebooksArray
     */
    public function getNotebooksArray() {
        return $this->notebooksArray;
    }

    private function prepareCommentBubble($id, $comments) {
        $html = "<span class='comment-bubble'>";
        $html .= "<span class='heading'>Comments";
        $html .= "</span>";
        $html .= "<div id='comment-bubble-inner-wrapper'>";
        $html .= "<p>" . $comments . "</p>";
        $html .= "<textarea id='comment-bubble-$id'></textarea>";
        $html .= "<div id='comment-bubble-button-wrapper'><a class='button' onclick='CommentsBubble.addComment()'>Send</a></div>";
        $html .= "</div>";
        $html .= "</span>";
        return $html;
    }

    public function populateAssignedNotebooksTable() {
        $tableBody = '';

        if (!empty($this->notebooksArray)) {
            foreach ($this->notebooksArray as $id => $notebook) {
                if ($notebook['reviewer_id'] == $_SESSION['id']) {
                    $notebookNo = $notebook['notebook_no'];
                    $assigedDate = $this->Functions->convertMysqlDateToPhpDate($notebook['created_date']);
                    $status = $notebook['status_name'];
                    $author = $notebook['author_username'];
                    $commentBubble = $this->prepareCommentBubble($id, $notebook['comments']);
                    $statusDropDown = $this->Statuses->populateStatusesforTable($status);

                    $tableBody .= "<tr id='assigned-$id'>";
                    $tableBody .= "<td>$notebookNo$commentBubble</td>";
                    $tableBody .= "<td>$assigedDate</td>";
                    $tableBody .= "<td>$statusDropDown</td>";
                    $tableBody .= "<td>$author</td>";
                    $tableBody .= "</tr>";
                    $zIndex--;
                }
            }
        } else {
            $tableBody = "<tr><td colspan='4'>There are no notebooks</td></tr>";
        }
        echo $tableBody;
    }

    public function populateMyNotebooksTable() {
        $tableBody = '';

        if (!empty($this->notebooksArray)) {
            foreach ($this->notebooksArray as $id => $notebook) {
                if ($notebook['author_id'] == $_SESSION['id']) {
                    $notebookNo = $notebook['notebook_no'];
                    $assigedDate = $this->Functions->convertMysqlDateToPhpDate($notebook['created_date']);
                    $status = $notebook['status_name'];
                    $reviewer = $notebook['reviewer_username'];
                    $commentBubble = $this->prepareCommentBubble($notebook['comments']);

                    $tableBody .= "<tr id='my-$id'>";
                    $tableBody .= "<td>$notebookNo$commentBubble</td>";
                    $tableBody .= "<td>$status</td>";
                    $tableBody .= "<td>$reviewer</td>";
                    $tableBody .= "<td>$assigedDate</td>";
                    $tableBody .= "</tr>";
                }
            }
        } else {
            $tableBody = "<tr><td colspan='4'>There are no notebooks</td></tr>";
        }
        echo $tableBody;
    }

    public function populateRecentNotebooksTable() {
        $tableBody = '';

        if (!empty($this->notebooksArray)) {
            foreach ($this->notebooksArray as $id => $notebook) {
                $notebookNo = $notebook['notebook_no'];
                $assigedDate = $this->Functions->convertMysqlDateToPhpDate($notebook['created_date']);
                $status = $notebook['status_name'];
                $author = $notebook['author_username'];
                $reviewer = $notebook['reviewer_username'];
                $commentBubble = $this->prepareCommentBubble($notebook['comments']);

                $tableBody .= "<tr>";
                $tableBody .= "<td>$notebookNo$commentBubble</td>";
                $tableBody .= "<td>$author</td>";
                $tableBody .= "<td>$status</td>";
                $tableBody .= "<td>$reviewer</td>";
                $tableBody .= "<td>$assigedDate</td>";
                $tableBody .= "</tr>";
            }
        } else {
            $tableBody = "<tr><td colspan='4'>There are no notebooks</td></tr>";
        }
        echo $tableBody;
    }

    public function addNewNotebook($notebookNo, $assignedTo, $comments) {
        $sql = "INSERT INTO notebooks (notebook_no, author_id, reviewer_id, last_modified_date, comments) ";
        $sql .= "SELECT :notebook_no, :author_id, id, :currentDate, :comments FROM %s.users WHERE username = :username";

        $query = sprintf($sql, Constants::OMS_DB_NAME);

        $currentDate = date("Y-m-d H:i:s");
        $stmt = $this->Database->prepare($query);
        $stmt->bindValue(':notebook_no', $notebookNo, PDO::PARAM_STR);
        $stmt->bindValue(':author_id', "1", PDO::PARAM_STR);
        $stmt->bindValue(':currentDate', $currentDate, PDO::PARAM_STR);
        $stmt->bindValue(':comments', $comments, PDO::PARAM_STR);
        $stmt->bindValue(':username', $assignedTo, PDO::PARAM_STR);
        return $stmt->execute();
    }

}

?>