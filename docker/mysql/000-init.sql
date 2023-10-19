USE csd223_lab1;

CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `posts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `content` text NOT NULL,
    `user_id` int(11) NOT NULL,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `comments` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `content` text NOT NULL,
    `user_id` int(11) NOT NULL,
    `post_id` int(11) NOT NULL,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `post_id` (`post_id`),
    CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `likes` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `post_id` int(11) NOT NULL,
    `created_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `post_id` (`post_id`),
    CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add some users to the users table in the database
INSERT INTO users (username, password, email, created_at, updated_at) VALUES ('admin', '$2y$10$8SSXtp1N7slRZEu3Xx2EgurmmiKfNG/y5..two35RUZC.PxnI1XsW', 'admin@localhost', NOW(), NOW());
SET @admin_id = LAST_INSERT_ID();
INSERT INTO users (username, password, email, created_at, updated_at) VALUES ('user1', '$2y$10$iqkHhYPmv8ieCq20Yc024uHx2A9.zkmWvoe1Jmw5giszwX9My26pW', 'user1@localhost', NOW(), NOW());
SET @user1_id = LAST_INSERT_ID();

-- Add some posts
INSERT INTO posts (title, content, user_id, created_at, updated_at) VALUES ('Post 1', 'This is the content of post 1', @admin_id, NOW(), NOW());
INSERT INTO posts (title, content, user_id, created_at, updated_at) VALUES ('Post 2', 'This is the content of post 2', @user1_id, NOW(), NOW());
INSERT INTO posts (title, content, user_id, created_at, updated_at) VALUES ('Post 3', 'This is the content of post 3', @admin_id, NOW(), NOW());
INSERT INTO posts (title, content, user_id, created_at, updated_at) VALUES ('Post 4', 'This is the content of post 4', @user1_id, NOW(), NOW());