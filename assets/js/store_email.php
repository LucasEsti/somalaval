<?php
// Autoriser les requêtes CORS
header("Access-Control-Allow-Origin: *");  // Autorise toutes les origines (*)
header("Access-Control-Allow-Methods: POST, OPTIONS");  // Autorise POST et OPTIONS
header("Access-Control-Allow-Headers: Content-Type");

// Connexion à la base de données
$host = '127.0.0.1';
$dbname = 'xnrafbmy_somalaval';
$user = 'xnrafbmy_batpro';
$password = '7q8o.5)TSp';

try {
    $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8mb4';
    $pdo = new PDO($dsn, $user, $password);
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
        $to = "webmaster@fitaratra.mg, showroom@somalaval.com";
        $subject = "Téléchargement de fiche technique";
        $subject = mb_encode_mimeheader($subject, "UTF-8", "B", "\r\n");
        $message = "L'email $email a téléchargé le fichier : $fileUrl";
        $headers = "From: no-reply@somalaval.com\r\n";
        $headers .= "Reply-To: no-reply@somalaval.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "Content-Transfer-Encoding: 8bit\r\n";

        mail($to, $subject, $message, $headers);
        $product = $_POST['product'];
        $to = $_POST['email'];
        $subject = "Votre fiche technique $product – Nous sommes là pour vous aider";
        $subject = mb_encode_mimeheader($subject, "UTF-8", "B", "\r\n");
        $message = "Cher(e) client(e),\r\n
            Merci d’avoir téléchargé la fiche technique de notre produit [Nom du produit]. Nous espérons qu’elle vous sera utile !\r\n
            Si vous avez des questions ou besoin de précisions, notre équipe se tient à votre disposition pour vous accompagner et vous fournir des conseils adaptés à vos besoins.
            Vous souhaitez en savoir plus ? Répondez simplement à cet e-mail ou rendez vous à notre showroom Anosivavaka, Antananarivo ou à notre usine de Tamatave.\r\n
            À bientôt,\r\n
            showroom@somalaval.com\r\n
            Commercial SOMALAVAL Usine : RN2 PK 3.5, Toamasina \r\n 
            Showroom : Business Park Anosivavaka, Bâtiment E \r\n
            032 11 111 06\r\n
            020 53 338 08\r\n
            ";
        $headers = "From: showroom@somalaval.com\r\n";
        $headers .= "Reply-To: showroom@somalaval.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "Content-Transfer-Encoding: 8bit\r\n";

        mail($to, $subject, $message, $headers);
        
        //notification à l'utilisateur
        
        echo "Success";
    } else {
        echo "Invalid email or file URL";
    }
}
?>
