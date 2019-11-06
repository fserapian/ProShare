<?php

session_start();

// flash message helper

// Example - flash('register_success', 'You are now registered', 'card-panel green darken-1 white-text');
// Display in view - flash('register_success')

function flash($name = '', $message = '', $class = 'card-panel green white-text')
{
    // make sure there is a name
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {

            // if session not empty unset it
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }

            if (!empty($_SESSION[$name . '_class'])) {
                unset($_SESSION[$name . '_class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } else if (empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
            if (strpos($class, 'green')) {
                echo '<div class="' . $class . '" id="msg-flash"><i class="material-icons left">check_circle</i><span>' . $_SESSION[$name] . '</span></div>';
            } else if (strpos($class, 'red')) {
                echo '<div class="' . $class . '" id="msg-flash"><i class="material-icons left">error</i><span>' . $_SESSION[$name] . '</span></div>';
            } else if (strpos($class, 'orange')) {
                echo '<div class="' . $class . '" id="msg-flash"><i class="material-icons left">info</i><span>' . $_SESSION[$name] . '</span></div>';
            }

            // unset sessions after use
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}

function isLoggedIn()
{
    // return true if user is logged in, otherwise return false
    return isset($_SESSION['user_id']);
}
