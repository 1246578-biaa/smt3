<?php
require_once __DIR__ . '/helpers.php';

class BaseController
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);  
        require __DIR__ . '/../views/shared/header.php';
        require __DIR__ . '/../views/' . $view . '.php';
        require __DIR__ . '/../views/shared/footer.php';
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    protected function flash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'msg' => $message];
    }

    protected function withOld(array $data): void
    {
        $_SESSION['old'] = $data;
    }

    protected function pullOld(): array
    {
        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['old']);
        return $old;
    }
}