<?php
?>
<button id="download-btn" class="btn btn-color">Télécharger la fiche technique</button>
<div id="email-modal" style="display: none;">
    <label for="email">Entrez votre email :</label>
    <input type="email" id="email" required>
    <button id="submit-email">Envoyer</button>
</div>

<a id="download-link" href="https://somalaval.com/sites/default/files/2021-05/IKARBOIS.PDF" download style="display: none;"></a>

<script>
document.getElementById('download-btn').addEventListener('click', function () {
    document.getElementById('email-modal').style.display = 'block';
});

document.getElementById('submit-email').addEventListener('click', function () {
    var email = document.getElementById('email').value;
    var fileUrl = document.getElementById('download-link').getAttribute('href'); // Récupère le lien du fichier

    if (email) {
        fetch('store_email.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'email=' + encodeURIComponent(email) + '&file_url=' + encodeURIComponent(fileUrl)
        }).then(response => response.text()).then(data => {
            alert('Votre email a été enregistré. Le téléchargement va commencer.');
            document.getElementById('email-modal').style.display = 'none';
            //Sdocument.getElementById('download-link').click();
        });
    } else {
        alert('Veuillez entrer un email valide.');
    }
});
</script>



