<?php
/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 08/03/2016                                                                 */
/* Last modified on 09/01/2016                                                           */
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

if (!$Session->isSessionValid()) {
    $Functions->phpRedirect('login');
}
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
        <?php require_once (PRIVATE_PATH . 'require/add-new-item-popup.php'); ?>
        <div id="main-toast-wrapper"></div>
        <div id="gray-out-div"></div>
        <img id="progress-bar" src="images/progress-bar.gif"/>
        <div id="home-main-body-wrapper">
            <span id='version-span'>Version 1.0.0.<?php echo file_get_contents($file); ?></span>
            <div style="display: table;" id="main-wrapper-table">
                <div style="display: table-row;" class="main-wrapper-table-tr">
                    <div style="display: table-cell;" class="main-wrapper-table-td">
                        <div id="assigned-notebooks-for-review-table-wrapper" class="table-wrapper">
                            <div class="heading table-heading">Notebooks Assigned to Me</div>
                            <table id="assigned-notebooks-for-review-table-wrapper" class="notebooks-table collapsable-table scrollable-table collapsable-table-1">
                                <thead>
                                    <tr>
                                        <th title="Notebook No">Notebook No</th>
                                        <th title="Status">Status</th>
                                        <th title="Author">Author</th>
                                        <th title="Assigned Date">Assigned Date</th>
                                        <th></th>
                                    </tr>
                                    <tr class="shadow">
                                        <th colspan="5"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo $Notebooks->populateAssignedNotebooksTable();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="my-notebooks-waiting-for-review-table-wrapper" class="table-wrapper">
                            <div class="heading table-heading">My Notebooks</div>
                            <table id="my-notebooks-table-wrapper" class="notebooks-table collapsable-table scrollable-table collapsable-table-2">
                                <thead>
                                    <tr>
                                        <th title="Notebook No">Notebook No</th>
                                        <th title="Reviewer">Reviewer</th>
                                        <th title="Status">Status</th>
                                        <th title="Assigned Date">Assigned Date</th>
                                        <th></th>
                                    </tr>
                                    <tr class="shadow">
                                        <th colspan="5"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo $Notebooks->populateMyNotebooksTable();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div style="display: table-row;" class="main-wrapper-table-td">
                        <div id="recently-added-notebooks-waiting-for-review-table-wrapper" class="table-wrapper">
                            <div class="heading table-heading">Recently Added Notebooks</div>
                            <table id="recently-added-notebooks-table-wrapper" class="notebooks-table scrollable-table">
                                <thead>
                                    <tr>
                                        <th title="Notebook No">Notebook No</th>
                                        <th title="Author">Author</th>
                                        <th title="Status">Status</th>
                                        <th title="Reviewer">Reviewer</th>
                                        <th title="Assigned Date">Assigned Date</th>
                                        <th></th>
                                    </tr>
                                    <tr class="shadow">
                                        <th colspan="6"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo $Notebooks->populateRecentNotebooksTable();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="main-error-div" class="error-div"></div>
            <div id="invisible-element"></div>
            <div id="notebook-table-element-holder"></div>
        </div>
    </body>
</html>

