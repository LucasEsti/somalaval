<?php
// Connexion à la base de données
$host = '127.0.0.1';
$dbname = 'xnrafbmy_somalaval';
$user = 'xnrafbmy_batpro';
$password = '7q8o.5)TSp';

try {
    $dsn = 'mysql:host=127.0.0.1;dbname=' . $bdd["database"] . ';charset=utf8mb4';
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}


// Vérifier si les données ont été envoyées
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'], $_POST['file_url'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $fileUrl = filter_var($_POST['file_url'], FILTER_SANITIZE_URL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($fileUrl)) {
        // Insérer dans la base de données
        $stmt = $pdo->prepare("INSERT INTO downloads (email, file_url) VALUES (?, ?)");
        $stmt->execute([$email, $fileUrl]);

        // Envoyer une notification par email
        $to = "votre-email@domaine.com";
        $subject = "Téléchargement de fiche technique";
        $message = "L'email $email a téléchargé le fichier : $fileUrl";
        $headers = "From: no-reply@somalaval.com";

        mail($to, $subject, $message, $headers);
        echo "Success";
    } else {
        echo "Invalid email or file URL";
    }
}
?>
