<?php

require __DIR__ . '/vendor/autoload.php';

use Brevo\Client\Configuration;
use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Model\SendSmtpEmail;

// Autoriser les requêtes CORS
header("Access-Control-Allow-Origin: *");  // Autorise toutes les origines (*)
header("Access-Control-Allow-Methods: POST, OPTIONS");  // Autorise POST et OPTIONS
header("Access-Control-Allow-Headers: Content-Type");

/*
NEW MAIL SYSTEM 
 */
function sendEmail($apiKey, $sender, $to, $subject, $content) {
    $config = Configuration::getDefaultConfiguration()
            ->setApiKey('api-key', $apiKey);

    $apiInstance = new TransactionalEmailsApi(
        new GuzzleHttp\Client(),
        $config
    );

    $email = new SendSmtpEmail([
        'subject'      => $subject,
        'sender'       => $sender,
        'to'           => $to,
        'htmlContent'  => $content,
        'params'       => ['name' => 'Dest'],          // remplace {{params.name}}
        // facultatif : 'replyTo', 'cc', 'bcc', 'attachment', etc.
    ]);

    try {
        $result = $apiInstance->sendTransacEmail($email);
        var_dump($result);          // ID du message, date, etc.
    } catch (Exception $e) {
        echo 'Erreur : ', $e->getMessage();
    }
}

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

        // mail($to, $subject, $message, $headers);
        
        $sender = ['email' => 'no-reply@somalaval.com'];
        $to = [['email' => 'webmaster@fitaratra.mg'], ['email' => 'showroom@somalaval.com']];
        $conf = json_decode(file_get_contents("./params.json"), true);
        $apiKey = $conf['key'];
        sendEmail($apiKey, $sender, $to, $subject, $message);
        
        $product = $_POST['product'];
        $to = $_POST['email'];
        $subject = "Votre fiche technique $product – Nous sommes là pour vous aider";
        $subject = mb_encode_mimeheader($subject, "UTF-8", "B", "\r\n");
        $message = "
            <html>
            <head>
                <meta charset='UTF-8'>
                <title>Merci pour votre téléchargement</title>
            </head>
            <body style='font-family: Arial, sans-serif; color: #333; text-align: center;'>

                <p> Cher(e) client(e), </p>

                <p>Merci d’avoir téléchargé la fiche technique de notre produit <strong>$product</strong>. Nous espérons qu’elle vous sera utile !</p>

                <p>Si vous avez des questions ou besoin de précisions, notre équipe se tient à votre disposition pour vous accompagner et vous fournir des conseils adaptés à vos besoins.</p>

                <p>
                    Vous souhaitez en savoir plus ? Répondez simplement à cet e-mail ou rendez-vous à notre showroom Anosivavaka, Antananarivo ou à notre usine de Tamatave.
                </p>

                <p>À bientôt,</p>

                <p><strong>L’équipe Somalaval</strong></p>

                <p>
                    <strong>📍 Usine Toamasina :</strong> RN2 PK 3.5, Barikadimy – 032 11 111 05 <br>
                    <strong>📍 Showroom Antananarivo :</strong> Route du Pape, Anosivavaka Business Park – 032 11 111 06
                </p>

                <!-- Table pour aligner les images côte à côte -->
                <table align='center' cellpadding='0' cellspacing='0' border='0'>
                    <tr>
                        <td style='padding: 10px;'>
                            <img src='https://somalaval.com/themes/apiqa/assets/img/somalaval.gif' alt='Image 1' width='150' style='display: block;'>
                        </td>
                        <td style='padding: 10px;'>
                            <img src='https://somalaval.com/themes/apiqa/assets/img/60.png' alt='Image 2' width='150' style='display: block;'>
                        </td>
                    </tr>
                </table>

            </body>
            </html>
        ";
        $headers = "From: showroom@somalaval.com\r\n";
        $headers .= "Reply-To: showroom@somalaval.com\r\n";
        
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n"; // Passage en HTML
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "Message-ID: <" . md5(uniqid()) . "@somalaval.com>\r\n"; // Identifiant unique

        mail($to, $subject, $message, $headers);
        
        //notification à l'utilisateur
        
        echo "Success upload";
    } else {
        echo "Invalid email or file URL";
    }
}
?>
