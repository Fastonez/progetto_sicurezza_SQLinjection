
<?php

// Se il DB non esiste, creiamo la tabella
if (!file_exists('database.db')) {
    include 'init.php';
} else {
    $percorso_db = __DIR__ . '/database.db';  // esempio: nella stessa cartella dello script

    $db = new SQLite3($percorso_db);
}

// Verifica se è stato inviato il form di login
if ($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($_GET['username']) || isset($_GET['password']))) {
    $username = $_GET['username'] ?? '';
    $password = $_GET['password'] ?? '';
    
    // Query vulnerabile a SQL injection
    $query = "SELECT * FROM utenti WHERE username = '$username' AND password = '$password'";
    
    // Mostra la query per debug
    // echo "<div style='background:#f0f0f0;padding:15px;margin-bottom:20px;border-radius:5px;'>";
    // echo "<strong>Query generata:</strong><br><code>" . htmlspecialchars($query) . "</code>";
    // echo "</div>";
    
    try {
        // Prima prova come SELECT (per il login normale)
        $result = $db->querySingle($query, true);
        
        if ($result) {
            echo "<div style='background:#d4edda;color:#155724;padding:15px;border-radius:5px;margin-bottom:20px;'>";
            echo "<strong>Accesso riuscito!</strong> Benvenuto, " . htmlspecialchars($result['username']) . ".";
            echo "</div>";
        } else {
            // echo "<div style='background:#f8d7da;color:#721c24;padding:15px;border-radius:5px;margin-bottom:20px;'>";
            // echo "<strong>Accesso fallito.</strong> Username o password errati.";
            echo "</div>";
            
            // Se la SELECT fallisce, prova a eseguire come comando generico (per UPDATE, DROP, ecc.)
            if ($db->exec($query) !== false) {
                echo "<div style='background:#fff3cd;color:#856404;padding:15px;border-radius:5px;margin-bottom:20px;'>";
                echo "<strong>Comando eseguito:</strong> La query ha modificato il database.";
                echo "</div>";
            }
        }
        
    } catch (Exception $e) {
        echo "<div style='background:#f8d7da;color:#721c24;padding:15px;border-radius:5px;margin-bottom:20px;'>";
        echo "<strong>Errore:</strong> " . htmlspecialchars($e->getMessage());
        echo "</div>";
    }
}

?> 



