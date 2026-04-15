-- Дамп базы данных для приложения "Список задач"
-- Создаем базу данных (если нет)
CREATE DATABASE IF NOT EXISTS task_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE task_manager;

-- Таблица задач
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status TINYINT DEFAULT 0 COMMENT '0 - новая, 1 - выполнена',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Пример данных (опционально)
INSERT INTO tasks (title, description, status) VALUES 
('Изучить PHP', 'Разобраться с основами синтаксиса', 1),
('Подключить MySQL', 'Настроить соединение с базой данных', 0),
('Сделать дизайн', 'Интегрировать макет от Квен-студии', 0);
