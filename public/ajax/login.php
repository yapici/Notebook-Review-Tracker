<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 08/22/2016                                                                 */
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

require('../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
// Getting the parameters passed through AJAX
    $sanitizedPostArray = $Functions->sanitizePostedVariables();
    $email = $sanitizedPostArray['email'];
    $enteredPassword = $sanitizedPostArray['password'];
    $currentDate = date("Y-m-d H:i:s");

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $domain = $Functions->getDomainFromEmail($email);

        if ($domain == Constants::DOMAIN_EMAIL_EXT) {
            $sql = "SELECT id, username, password, account_status, user_type, password_reset FROM %s.users ";
            $sql .= "WHERE email = ?";
            $sql = sprintf($sql, Constants::OMS_DB_NAME);
            $stmt = $Database->prepare($sql);
            $stmt->bindValue(1, $email, PDO::PARAM_STR);

            $result = $stmt->execute();

            if ($result) {
                if ($stmt->rowCount() == 0) {
                    $jsonResponse['status'] = "invalid_info";
                } else {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $hash = $row['password'];
                    if (password_verify($enteredPassword, $hash)) {
                        if ($row['account_status'] == '1') {
                            if ($row['password_reset'] == '0') {
                                $Session->afterSuccessfulLogin();
                                $_SESSION['id'] = $row['id'];
                                $_SESSION['username'] = $row['username'];
                                $_SESSION['email'] = $email;

                                $jsonResponse['status'] = "success";
                            } else {
                                $_SESSION['id'] = $row['id'];
                                $jsonResponse['status'] = "reset_password";
                            }
                        } else {
                            $jsonResponse['status'] = "no_activation";
                        }
                    } else {
                        $jsonResponse['status'] = "wrong_combination";
                    }
                }
            } else {
                $jsonResponse['status'] = "fail";
            }
        } else {
            $jsonResponse['status'] = 'invalid_domain_name';
        }
    } else {
        $jsonResponse['status'] = 'invalid_email_address';
    }
    echo json_encode($jsonResponse);
} else {
    $Functions->phpRedirect('');
}
?>
