<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un nouveau média - MediApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/path/to/your/styles.css">
    <script>
        function showSpecificFields() {
            // Réinitialise les attributs `required` sur tous les champs spécifiques
            document.getElementById('pageNumber').removeAttribute('required');
            document.getElementById('duration').removeAttribute('required');
            document.getElementById('genre').removeAttribute('required');
            document.getElementById('songNumber').removeAttribute('required');
            document.getElementById('editor').removeAttribute('required');

            // Masque tous les champs spécifiques
            document.getElementById('bookFields').style.display = 'none';
            document.getElementById('movieFields').style.display = 'none';
            document.getElementById('albumFields').style.display = 'none';

            // Affiche uniquement les champs spécifiques au type sélectionné et ajoute l’attribut `required` selon le type
            var mediaType = document.getElementById('mediaType').value;
            if (mediaType === 'Book') {
                document.getElementById('bookFields').style.display = 'block';
                document.getElementById('pageNumber').setAttribute('required', 'required');
            } else if (mediaType === 'Movie') {
                document.getElementById('movieFields').style.display = 'block';
                document.getElementById('duration').setAttribute('required', 'required');
                document.getElementById('genre').setAttribute('required', 'required');
            } else if (mediaType === 'Album') {
                document.getElementById('albumFields').style.display = 'block';
                document.getElementById('songNumber').setAttribute('required', 'required');
                document.getElementById('editor').setAttribute('required', 'required');
            }
        }
    </script>
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Ajouter un nouveau média</h1>
        
        <form method="POST" action="/media/save" class="p-4 border rounded bg-light">
            <!-- Champs généraux -->
            <div class="mb-3">
                <label for="titre" class="form-label">Titre :</label>
                <input type="text" class="form-control" id="titre" name="titre" required>
            </div>

            <div class="mb-3">
                <label for="auteur" class="form-label">Auteur :</label>
                <input type="text" class="form-control" id="auteur" name="auteur" required>
            </div>

            <div class="mb-3">
                <label for="disponible" class="form-label">Disponibilité :</label>
                <select id="disponible" name="disponible" class="form-select" required>
                    <option value="1">Oui</option>
                    <option value="0">Non</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="mediaType" class="form-label">Type de média :</label>
                <select id="mediaType" name="mediaType" class="form-select" onchange="showSpecificFields()" required>
                    <option value="">Sélectionner un type</option>
                    <option value="Book">Livre</option>
                    <option value="Movie">Film</option>
                    <option value="Album">Album</option>
                </select>
            </div>

            <!-- Champs spécifiques pour un livre -->
            <div id="bookFields" class="mb-3" style="display: none;">
                <h4>Informations pour un livre</h4>
                <label for="pageNumber" class="form-label">Nombre de pages :</label>
                <input type="number" class="form-control" id="pageNumber" name="pageNumber" min="1">
                <input type="hidden" id="type" name="type" value="book">
            </div>

            <!-- Champs spécifiques pour un film -->
            <div id="movieFields" class="mb-3" style="display: none;">
                <h4>Informations pour un film</h4>
                <label for="duration" class="form-label">Durée (en minutes) :</label>
                <input type="number" class="form-control" id="duration" name="duration" min="1">

                <label for="genre" class="form-label">Genre :</label>
                <select id="genre" name="genre" class="form-select">
                    <option value="">Sélectionner un genre</option>
                    <option value="ACTION">Action</option>
                    <option value="COMEDY">Comédie</option>
                    <option value="DRAMA">Drame</option>
                    <option value="HORROR">Horreur</option>
                    <option value="SCI_FI">Science-fiction</option>
                </select>
                <input type="hidden" id="type" name="type" value="movie">
            </div>

            <!-- Champs spécifiques pour un album -->
            <div id="albumFields" class="mb-3" style="display: none;">
                <h4>Informations pour un album</h4>
                <label for="songNumber" class="form-label">Nombre de morceaux :</label>
                <input type="number" class="form-control" id="songNumber" name="songNumber" min="1">

                <label for="editor" class="form-label">Éditeur :</label>
                <input type="text" class="form-control" id="editor" name="editor">
                <input type="hidden" id="type" name="type" value="album">
            </div>

            <button type="submit" class="btn btn-primary mt-3">Ajouter le média</button>
        </form>
    </div>
</body>
</html>
