<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim($_POST['title']);
        $description = trim($_POST['description'] ?? '');
        
        if (!empty($title)) {
            $stmt = $pdo->prepare("INSERT INTO tasks (title, description) VALUES (?, ?)");
            $stmt->execute([$title, $description]);
        }
    } elseif ($action === 'complete') {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("UPDATE tasks SET status = 'done' WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($action === 'reopen') {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("UPDATE tasks SET status = 'pending' WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($action === 'delete') {
        $id = (int)$_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->execute([$id]);
    }
}

header("Location: index.php");
exit;
