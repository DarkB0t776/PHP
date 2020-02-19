<?php
ob_start();
session_start();


function redirect($page = null, $message = [], $type = null)
{
    if (is_string($page)) {
        $location = $page;
    } else {
        $location = $_SERVER['SCRIPT_NAME'];
    }

    if ($message != null) {
        $_SESSION['message'] = $message;
    }
    if ($type != null) {
        $_SESSION['message_type'] = $type;
    }


    header("Location: $location");
    exit();
}

function displayMessage()
{
    if (!empty($_SESSION['message'])) {
        $messages = $_SESSION['message'];

        if (!empty($_SESSION['message_type'])) {
            $messageType = $_SESSION['message_type'];
            if ($messageType === 'error') {
                $ulLink = '';
                foreach ($messages as $message) {
                    $ulLink .= "<li>$message</li>";
                }
                print <<<HTML
                        <div class="message {$messageType}">
                            <ul>
                                $ulLink
                            </ul>
                        </div>
                 HTML;
            } else {
                print <<<HTML
                <div class="message success">
                    <ul>
                        <li>{$messages[0]}</li>
                    </ul>
                </div>
         HTML;
            }
        }

        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    } else {
        echo '';
    }
}
