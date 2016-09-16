<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 08/05/2016                                                                 */
/* Last modified on 09/16/2016                                                           */
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
    private $Comments;
    private $Users;

    /** @var array $usersArray */
    public $notebooksArray;

    /**
     * @param Database $database
     * @param Functions $functions
     * @param Statuses $statuses
     * @param Comments $comments
     * @param Users $users
     */
    function __construct($database, $functions, $statuses, $comments, $users) {
        $this->Database = $database;
        $this->Functions = $functions;
        $this->Statuses = $statuses;
        $this->Comments = $comments;
        $this->Users = $users;
        $this->populateArray();
    }

    private function populateArray() {
        $this->notebooksArray = array();
        $query_string = "SELECT n.id, "
                . "n.notebook_no, "
                . "n.author_id, "
                . "n.reviewer_id, "
                . "n.status_id, "
                . "n.created_date, "
                . "u1.username AS author_username, "
                . "u2.username AS reviewer_username, "
                . "s.status_name "
                . "FROM notebooks AS n "
                . "JOIN %s.users AS u1 ON (n.author_id = u1.id) "
                . "JOIN %s.users AS u2 ON (n.reviewer_id = u2.id) "
                . "JOIN status s ON (n.status_id = s.id) ORDER BY n.id DESC";

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

    public function prepareCommentBubble($id) {
        $html = "<span class='comment-bubble'>";
        $html .= "<span class='heading'>Comments</span>";
        $html .= "<div class='comment-bubble-inner-wrapper'>";
        $html .= "<div class='error-div'>&nbsp;</div>";
        $html .= "<div class='comment-elements-outer-outer-wrappper'>";
        $html .= "<div class='comments-wrapper-$id comment-elements-outer-wrappper'>";
        $html .= $this->fetchComments($id);
        $html .= "</div>";
        $html .= "</div>";

        $html .= "<textarea class='comment-bubble-$id'></textarea>";
        $html .= "<div class='comment-bubble-button-wrapper'><a class='button' onclick='CommentsBubble.addComment(this)'>Send</a></div>";
        $html .= "</div>";
        $html .= "</span>";
        return $html;
    }

    public function fetchComments($id) {
        $html = "";
        $commentsArray = $this->Comments->getCommentsWithId($id);
//        if ($commentsArray != null) {
        if ($commentsArray != null && array_filter($commentsArray)) {
            foreach ($commentsArray as $comment) {
                $html .= "<p class='comment-elements-inner-wrapper'>";
                if ($comment['sender_id'] == $_SESSION['id']) {
                    $html .= "<span class='comment-username self'>" . $comment['username'] . "</span>";
                } else {
                    $html .= "<span class='comment-username'>" . $comment['username'] . "</span>";
                }
                $html .= "<span class='comment-message'>" . preg_replace('#<br\s*/?>#i', "<br/>", htmlspecialchars_decode($comment['comment'])) . "</span>";
                $html .= "<span class='comment-datetime'>" . $this->Functions->convertMysqlDateToDateTime($comment['datetime']) . "</span>";
                $html .= "</p>";
            }
        } else {
            $html .= "<div style='color: #aaaaaa;'>No comments have been added so far</div>";
        }
//        }
        return $html;
    }

    public function populateAssignedNotebooksTable() {
        $tableBody = '';

        if (!empty($this->notebooksArray)) {
            foreach ($this->notebooksArray as $id => $notebook) {
                if ($notebook['reviewer_id'] == $_SESSION['id']) {
                    $notebookNo = $notebook['notebook_no'];
                    $assigedDate = $this->Functions->convertMysqlDateToPhpDate($notebook['created_date']);
                    $statusId = $notebook['status_id'];
                    $author = $notebook['author_username'];
                    $commentBubble = $this->prepareCommentBubble($id);
                    $statusDropDown = $this->Statuses->populateStatusesforTable($statusId);

                    $tableBody .= "<tr id='assigned-$id'>";
                    $tableBody .= "<td title='$notebookNo'>$notebookNo$commentBubble</td>";
                    $tableBody .= "<td title='$author'>$author</td>";
                    $tableBody .= "<td>$statusDropDown</td>";
                    $tableBody .= "<td title='$assigedDate'>$assigedDate</td>";
                    $tableBody .= "</tr>";
                }
            }
        } else {
            $tableBody = "<tr><td colspan='4'>There are no notebooks</td></tr>";
        }
        return $tableBody;
    }

    public function populateMyNotebooksTable() {
        $tableBody = '';

        if (!empty($this->notebooksArray)) {
            foreach ($this->notebooksArray as $id => $notebook) {
                if ($notebook['author_id'] == $_SESSION['id']) {
                    $notebookNo = $notebook['notebook_no'];
                    $assigedDate = $this->Functions->convertMysqlDateToPhpDate($notebook['created_date']);
                    $statusId = $notebook['status_id'];
                    $reviewer = $notebook['reviewer_username'];
                    $commentBubble = $this->prepareCommentBubble($id);
                    $statusDropDown = $this->Statuses->populateStatusesforTable($statusId);

                    $tableBody .= "<tr id='my-$id'>";
                    $tableBody .= "<td title='$notebookNo'>$notebookNo$commentBubble</td>";
                    $tableBody .= "<td>$statusDropDown</td>";
                    $tableBody .= "<td title='$reviewer'>$reviewer</td>";
                    $tableBody .= "<td title='$assigedDate'>$assigedDate</td>";
                    $tableBody .= "</tr>";
                }
            }
        } else {
            $tableBody = "<tr><td colspan='4'>There are no notebooks</td></tr>";
        }
        return $tableBody;
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
                $commentBubble = $this->prepareCommentBubble($id);

                $tableBody .= "<tr>";
                $tableBody .= "<td title='$notebookNo'>$notebookNo$commentBubble</td>";
                $tableBody .= "<td title='$author'>$author</td>";
                $tableBody .= "<td title='$status'>$status</td>";
                $tableBody .= "<td title='$reviewer'>$reviewer</td>";
                $tableBody .= "<td title='$assigedDate'>$assigedDate</td>";
                $tableBody .= "</tr>";
            }
        } else {
            $tableBody = "<tr><td colspan='4'>There are no notebooks</td></tr>";
        }
        return $tableBody;
    }

    public function addNewNotebook($notebookNo, $assignedTo, $comment, $author) {
        $sql = "INSERT INTO notebooks (notebook_no, author_id, reviewer_id, created_by, last_modified_by, last_modified_date) ";
        $sql .= "SELECT :notebookNo, :authorId, id, :createdBy, :lastModifiedBy, :currentDate FROM %s.users WHERE username = :username";

        $query = sprintf($sql, Constants::OMS_DB_NAME);

        $authorId = $this->Users->getUserId($author);

        $currentDate = date("Y-m-d H:i:s");
        $stmt = $this->Database->prepare($query);
        $stmt->bindValue(':notebookNo', $notebookNo, PDO::PARAM_STR);
        $stmt->bindValue(':authorId', $authorId, PDO::PARAM_STR);
        $stmt->bindValue(':createdBy', $_SESSION['id'], PDO::PARAM_STR);
        $stmt->bindValue(':lastModifiedBy', $_SESSION['id'], PDO::PARAM_STR);
        $stmt->bindValue(':currentDate', $currentDate, PDO::PARAM_STR);
        $stmt->bindValue(':username', $assignedTo, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $notebookId = $this->Database->lastInsertId();
            
            $this->refreshArray();
            if ($comment != "") {
                if ($this->Comments->addComment($notebookId, $comment, $_SESSION['id'])) {
                    $this->Comments->refreshArray();
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function getNotebookDetails($id) {
        return $this->notebooksArray[$id];
    }

}

?>