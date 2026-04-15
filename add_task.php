<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim($_POST['title']);
        $description = trim($_POST['description'] ?? '');
        
        if (!empty($title)) {
            // Новая задача сразу со статусом 0
            $stmt = $pdo->prepare("INSERT INTO tasks (title, description, status) VALUES (?, ?, 0)");
            $stmt->execute([$title, $description]);
        }
    } elseif ($action === 'complete') {
        $id = (int)$_POST['id'];
        // Ставим статус 1 (выполнена)
        $stmt = $pdo->prepare("UPDATE tasks SET status = 1 WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($action === 'reopen') {
        $id = (int)$_POST['id'];
        // Возвращаем статус 0 (новая)
        $stmt = $pdo->prepare("UPDATE tasks SET status = 0 WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($action === 'delete') {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->execute([$id]);
    }
}

header("Location: index.php");
exit;