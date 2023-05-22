<?php

class Database
{
    /**
     * Important table to authenticate the users with JWT on the web service
     */
    public function usersTable()
    {
        $table = "(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(256) NOT NULL UNIQUE,
            password VARCHAR(256) NOT NULL,
            permission ENUM('admin','supervisor','common') NOT NULL,
            createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
            updatedAt DATETIME
            )";
        return $table;
    }

    public function topicsTable()
    {
        $table = "(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(256) NOT NULL,
            description TEXT NOT NULL,
            keywords VARCHAR(256) NOT NULL,
            createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
            updatedAt DATETIME
            )";
        return $table;
    }

    public function commentsTable()
    {
        $table = "(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            fk_topic INT NOT NULL,
            fk_user INT NOT NULL,
            comment VARCHAR(256) NOT NULL,
            createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
            updatedAt DATETIME,
            FOREIGN KEY (fk_user) REFERENCES users(id),
            FOREIGN KEY (fk_topic) REFERENCES topics(id)
            )";
        return $table;
    }

    /**
     * Adds a first admin user on users table
     */
    public function adminUserData()
    {
        $password = password_hash("admin", PASSWORD_BCRYPT);
        $data = "INSERT INTO users (username, password, permission) VALUES('admin', '$password', 'admin')";
        return $data;
    }

    /**
     * Table example with foreign key reference
     */
    /*public function logTable()
    {
        $table = "(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            fk_user INT NOT NULL,
            method VARCHAR(512) NOT NULL,
            comment TEXT(1000) NOT NULL,
            createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
            FOREIGN KEY (fk_user) REFERENCES users(id)
            )";
        return $table;
    }*/

    /**
     * An example of how incluse a view
     */
    /*public function logView()
    {
        $view = "LOG.id, LOG.fk_user, USER.username, LOG.method, LOG.comment, LOG.createdAt FROM log LOG LEFT JOIN users USER ON fk_user = USER.id;";
        return $view;
    }*/

}
