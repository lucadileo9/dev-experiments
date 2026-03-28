<?php
namespace Core;

class Validator
{
    public static function validateNoteContent($content)
    {
        $content = trim($content);
        if (empty($content)) {
            return false;
        }
        if (strlen($content) > 255 || strlen($content) < 5) {
            return false;
        }
        return true; // No errors
    }

    public static function validateEmail($email)
    {
        $email = trim($email);
        if (empty($email)) {
            return false;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true; // No errors
    }

    public static function validatePassword($password)
    {
        if (strlen($password) < 6) {
            return false;
        }
        return true; // No errors
    }
}