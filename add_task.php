<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (!empty($title)) {
        $stmt = $pdo->prepare("INSERT INTO tasks (title, description) VALUES (:title, :desc)");
        $stmt->execute(['title' => $title, 'desc' => $description]);
    }
}

header('Location: index.php');
exit;
?>
