<?php
/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 08/03/2016                                                                 */
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    <head>
        <title>Notebook Review Tracker</title>
        <?php require_once ('include_references.php'); ?>
    </head>

    <body>
        <?php require_once (PRIVATE_PATH . 'require/header.php'); ?>     
        <div id="main-toast-wrapper"></div>
        <div id="gray-out-div"></div>
        <img id="progress-bar" src="images/progress-bar.gif"/>
        <div id="home-main-body-wrapper">
            <div id="add-new-notebook-items-wrapper">
                <div class="heading" onclick="AddNewItem.toggleAddNewItemView()">Add New Notebook for Review</div>
                <div id="add-new-notebook-items-inner-wrapper">
                    <div id="add-new-item-error-div" class="error-div"></div>
                    <select id="add-new-item-division">
                        <option disabled selected>Division</option>
                        <option value="DIV1">DIV1</option>
                        <option value="DIV2">DIV2</option>
                        <option value="DIV3">DIV3</option>
                        <option value="DIV4">DIV4</option>
                    </select>
                    <select id="add-new-item-project">
                        <option disabled selected>Project</option>
                        <option value="Project1">Project1</option>
                        <option value="Project2">Project2</option>
                        <option value="Project3">Project3</option>
                        <option value="Project4">Project4</option>
                        <option value="Project5">Project5</option>
                        <option value="Project6">Project6</option>
                        <option value="Project7">Project7</option>
                    </select>
                    <input  id="add-new-item-number" type="number" placeholder="Entry No (e.g. 38)"></input>
                    <?php
                    $Users->populateUsersDropdown("add-new-item-reviewer");
                    ?>
                    <textarea placeholder="Comments" id="add-new-item-comments"></textarea>
                    <a class="button" onclick="AddNewItem.addNewItem()">Submit</a>
                </div>
            </div>
            <div id="assigned-notebooks-for-review-table-wrapper" class="table-wrapper">
                <div class="heading table-heading">Notebooks Assigned to Me</div>
                <table id="assigned-notebooks-for-review-table-wrapper">
                    <thead>
                        <tr>
                            <th>Notebook No</th>
                            <th>Assigned Date</th>
                            <th>Status</th>
                            <th>Author</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $Notebooks->populateAssignedNotebooksTable();
                        ?>
                    </tbody>
                </table>
            </div>
            <div id="my-notebooks-waiting-for-review-table-wrapper" class="table-wrapper">
                <div class="heading table-heading">My Notebooks</div>
                <table id="my-notebooks-table-wrapper">
                    <thead>
                        <tr>
                            <th>Notebook No</th>
                            <th>Status</th>
                            <th>Reviewer</th>
                            <th>Assigned Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $Notebooks->populateMyNotebooksTable();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>

