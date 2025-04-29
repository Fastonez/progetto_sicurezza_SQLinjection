<?php
$db = new SQLite3('database.db');

$db->exec("CREATE TABLE utenti (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT,
    password TEXT,
    ruolo TEXT
)");

$db->exec("INSERT INTO utenti (username, password, ruolo) VALUES 
('admin', 'admin123', 'admin'),
('mario', 'ciao123', 'user'),
('giulia', 'passw0rd', 'user')");
?>
