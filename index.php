<?php
require_once 'db.php';

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

$sql = "SELECT * FROM tasks";
if ($filter === 'active') {
    $sql .= " WHERE status != 'done'";
} elseif ($filter === 'done') {
    $sql .= " WHERE status = 'done'";
}
$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->query($sql);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        
        <div class="filters">
            <a href="?filter=all" class="btn <?= $filter === 'all' ? 'active' : '' ?>">Все</a>
            <a href="?filter=active" class="btn <?= $filter === 'active' ? 'active' : '' ?>">Активные</a>
            <a href="?filter=done" class="btn <?= $filter === 'done' ? 'active' : '' ?>">Завершенные</a>
        </div>

        <form action="add_task.php" method="POST" class="task-form">
            <input type="text" name="title" placeholder="Название задачи" required>
            <textarea name="description" placeholder="Описание"></textarea>
            <button type="submit" name="action" value="add">Добавить</button>
        </form>

        <ul class="task-list">
            <?php foreach ($tasks as $task): ?>
                <li class="task-item <?= $task['status'] === 'done' ? 'completed' : '' ?>">
                    <div class="task-content">
                        <h3><?= htmlspecialchars($task['title']) ?></h3>
                        <p><?= htmlspecialchars($task['description']) ?></p>
                        <small><?= $task['created_at'] ?></small>
                    </div>
                    <div class="task-actions">
                        <?php if ($task['status'] !== 'done'): ?>
                            <form action="add_task.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                <button type="submit" name="action" value="complete" class="btn-success">✔</button>
                            </form>
                        <?php else: ?>
                            <form action="add_task.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                <button type="submit" name="action" value="reopen" class="btn-warning">↺</button>
                            </form>
                        <?php endif; ?>
                        
                        <form action="add_task.php" method="POST" style="display:inline;" onsubmit="return confirm('Удалить задачу?');">
                            <input type="hidden" name="id" value="<?= $task['id'] ?>">
                            <button type="submit" name="action" value="delete" class="btn-danger">✖</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        
        <?php if (empty($tasks)): ?>
            <p class="empty-message">Задач не найдено.</p>
        <?php endif; ?>
    </div>
</body>
</html>
