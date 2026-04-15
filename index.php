<?php
require_once 'db.php';

// Получаем параметр фильтра из URL (все, active, done)
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Формируем SQL запрос в зависимости от фильтра
$sql = "SELECT * FROM tasks";
if ($filter === 'active') {
    $sql .= " WHERE status = 'pending'";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Менеджер задач</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Список задач</h1>

        <!-- Блок фильтров -->
        <div class="filters">
            <a href="?filter=all" class="btn <?php echo $filter === 'all' ? 'active' : ''; ?>">Все</a>
            <a href="?filter=active" class="btn <?php echo $filter === 'active' ? 'active' : ''; ?>">Активные</a>
            <a href="?filter=done" class="btn <?php echo $filter === 'done' ? 'active' : ''; ?>">Завершенные</a>
        </div>

        <!-- Форма добавления -->
        <form action="add_task.php" method="POST" class="task-form">
            <input type="text" name="title" placeholder="Название задачи" required>
            <textarea name="description" placeholder="Описание"></textarea>
            <button type="submit" name="action" value="add">Добавить</button>
        </form>

        <!-- Список задач -->
        <ul class="task-list">
            <?php if (count($tasks) > 0): ?>
                <?php foreach ($tasks as $task): ?>
                    <li class="task-item <?php echo $task['status'] === 'done' ? 'completed' : ''; ?>">
                        <div class="task-content">
                            <h3><?php echo htmlspecialchars($task['title']); ?></h3>
                            <p><?php echo htmlspecialchars($task['description']); ?></p>
                            <small>Дата: <?php echo $task['created_at']; ?></small>
                        </div>
                        <div class="task-actions">
                            <?php if ($task['status'] === 'pending'): ?>
                                <form action="add_task.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                    <button type="submit" name="action" value="complete">✔</button>
                                </form>
                            <?php else: ?>
                                <form action="add_task.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                    <button type="submit" name="action" value="reopen" class="btn-reopen">↺</button>
                                </form>
                            <?php endif; ?>
                            
                            <form action="add_task.php" method="POST" style="display:inline;" onsubmit="return confirm('Удалить задачу?');">
                                <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                <button type="submit" name="action" value="delete" class="btn-delete">✖</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="no-tasks">Задач не найдено.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
