<?php 
    use App\Models\Album;
    use App\Models\Book;
    use App\Models\Movie;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du média</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/path/to/your/styles.css">
    <script>
        // Modale de confirmation de suppression
        function openDeleteModal() {
            document.getElementById('deleteModal').style.display = 'block';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Détails du média</h1>

        <div class="media-details bg-light p-4 rounded border">
            <p><strong>Titre :</strong> <?= $media->getTitre() ?></p>
            <p><strong>Auteur :</strong> <?= $media->getAuteur() ?></p>
            <p><strong>Disponibilité :</strong> <?= $media->isDisponible() ? 'Disponible' : 'Non disponible' ?></p>

            <!-- Champs spécifiques selon le type de média -->
            <?php if ($media instanceof Book): ?>
                <p><strong>Nombre de pages :</strong> <?= $media->getPageNumber() ?></p>
            <?php elseif ($media instanceof Movie): ?>
                <p><strong>Durée :</strong> <?= $media->getDuration() ?> minutes</p>
                <p><strong>Genre :</strong> <?= $media->getGenre() ?></p>
            <?php elseif ($media instanceof Album): ?>
                <p><strong>Nombre de sons :</strong> <?= $media->getSongNumber() ?></p>
                <p><strong>Éditeur :</strong> <?= $media->getEditor() ?></p>
            <?php endif; ?>
        </div>

        <!-- Changer la disponibilité -->
        <form action="/media/toggleAvailability" method="post" class="my-3">
            <input type="hidden" name="media_id" value="<?= $id ?>">
            <button type="submit" class="btn btn-warning">
                <?= $media->isDisponible() ? 'Marquer comme non disponible' : 'Marquer comme disponible' ?>
            </button>
        </form>

        <!-- Bouton de modification -->
        <a href="/media/edit/<?= $id ?>" class="btn btn-primary me-2">Modifier ce média</a>

        <!-- Bouton de suppression -->
        <button onclick="openDeleteModal()" class="btn btn-danger">Supprimer ce média</button>

        <!-- Modale de confirmation de suppression -->
        <div id="deleteModal" class="modal">
            <div class="modal-content bg-light p-4 rounded border">
                <h2>Confirmation de suppression</h2>
                <p>Êtes-vous sûr de vouloir supprimer ce média ? Cette action est irréversible.</p>
                <form action="/media/delete/<?= $id ?>" method="post">
                    <input type="hidden" name="media_id" value="<?= $id ?>">
                    <button type="submit" class="btn btn-danger me-2">Oui, supprimer</button>
                    <button type="button" onclick="closeDeleteModal()" class="btn btn-secondary">Annuler</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Style de la modale */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            text-align: center;
        }
    </style>
</body>
</html>
