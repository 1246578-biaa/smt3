<?php
namespace app\controllers;

class AuthController
{
    public function loginForm()
    {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);  
        require __DIR__ . '/../views/auth/login.php';
    }

    public function login()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username === 'admin' && $password === 'admin11') {
            session_regenerate_id(true);
            $_SESSION['user_id']   = 1;
            $_SESSION['user_name'] = 'Admin';
            $_SESSION['logged_in'] = true;
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Selamat datang, Admin'];
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Username atau password salah'];
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    public function logout()
    {
        unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['logged_in']);
        $_SESSION['flash'] = ['type' => 'info', 'message' => 'Anda telah logout'];
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}