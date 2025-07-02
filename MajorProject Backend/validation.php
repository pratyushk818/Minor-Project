<?php
session_start();

$valid_password = "SecurePass@123";
$valid_email_otp = "654321";
$valid_security_answer = "flu";

$user_password = $_POST['password'] ?? '';
$user_otp = $_POST['otp'] ?? '';
$user_security_answer = $_POST['security_answer'] ?? '';

$factor_count = 3;

function isPasswordStrong($password) {
    return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&+=!]).{8,}$/', $password);
}

if (!isPasswordStrong($user_password)) {
    echo "❌ Weak password. Use at least 1 uppercase, 1 lowercase, 1 digit, 1 special char, and min 8 chars.";
    exit;
}

if ($user_password !== $valid_password) {
    echo "❌ Incorrect password.";
    exit;
}

if ($factor_count >= 2) {
    if ($user_otp !== $valid_email_otp) {
        echo "❌ Invalid OTP.";
        exit;
    }
}

if ($factor_count === 3) {
    if (strtolower(trim($user_security_answer)) !== $valid_security_answer) {
        echo "❌ Incorrect security answer.";
        exit;
    }
}

echo "✅ Access granted with $factor_count-factor authentication.";
?>
