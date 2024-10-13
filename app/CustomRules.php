<?php
namespace App;

class CustomRules
{
    public function is_password_strong(string $password, string &$error = null): bool { // REF https://stackoverflow.com/a/32504388
        if (preg_match('#[0-9]#', $password) && preg_match('#[a-zA-Z]#', $password)) {
            return true;
        }

        $error = 'The password must contain at least one letter and one number.';
        return false;
    }
}


?>