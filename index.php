<?php
require_once 'db.php';

// Получаем список задач
$stmt = $pdo->query("SELECT * FROM tasks ORDER BY created_at DESC");
$tasks = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Менеджер задач</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Список задач</h1>
        
        <!-- Форма добавления -->
        <form action="add_task.php" method="POST" class="task-form">
            <input type="text" name="title" placeholder="Название задачи" required>
            <textarea name="description" placeholder="Описание"></textarea>
            <button type="submit">Добавить</button>
        </form>

        <!-- Список задач -->
        <ul class="task-list">
            <?php foreach ($tasks as $task): ?>
                <li class="task-item <?= $task['status'] ? 'done' : '' ?>">
                    <strong><?= htmlspecialchars($task['title']) ?></strong>
                    <p><?= htmlspecialchars($task['description']) ?></p>
                    <small>Дата: <?= $task['created_at'] ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
