<?php 
    use App\Models\Album;
    use App\Models\Book;
    use App\Models\Movie;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le média</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Modifier le média</h1>

        <form action="/media/update" method="post">
            <input type="hidden" name="media_id" value="<?= $media->getId() ?>">

            <div class="mb-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" class="form-control" id="titre" name="titre" value="<?= $media->getTitre() ?>" required>
            </div>

            <div class="mb-3">
                <label for="auteur" class="form-label">Auteur</label>
                <input type="text" class="form-control" id="auteur" name="auteur" value="<?= $media->getAuteur() ?>" required>
            </div>

            <div class="mb-3">
                <label for="disponible" class="form-label">Disponibilité</label>
                <select class="form-select" id="disponible" name="disponible">
                    <option value="1" <?= $media->isDisponible() ? 'selected' : '' ?>>Disponible</option>
                    <option value="0" <?= !$media->isDisponible() ? 'selected' : '' ?>>Non disponible</option>
                </select>
            </div>

            <!-- Champs supplémentaires pour les livres, films, albums selon le type -->
            <?php if ($media instanceof Book): ?>
                <div class="mb-3">
                    <label for="pageNumber" class="form-label">Nombre de pages</label>
                    <input type="number" class="form-control" id="pageNumber" name="pageNumber" value="<?= $media->getPageNumber() ?>" required>
                </div>
            <?php elseif ($media instanceof Movie): ?>
                <div class="mb-3">
                    <label for="duration" class="form-label">Durée (en minutes)</label>
                    <input type="number" class="form-control" id="duration" name="duration" value="<?= $media->getDuration() ?>" required>
                </div>
                <div class="mb-3">
                    <label for="genre" class="form-label">Genre</label>
                    <input type="text" class="form-control" id="genre" name="genre" value="<?= $media->getGenre() ?>" required>
                </div>
            <?php elseif ($media instanceof Album): ?>
                <div class="mb-3">
                    <label for="songNumber" class="form-label">Nombre de sons</label>
                    <input type="number" class="form-control" id="songNumber" name="songNumber" value="<?= $media->getSongNumber() ?>" required>
                </div>
                <div class="mb-3">
                    <label for="editor" class="form-label">Éditeur</label>
                    <input type="text" class="form-control" id="editor" name="editor" value="<?= $media->getEditor() ?>" required>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-success">Mettre à jour</button>
        </form>
    </div>
</body>
</html>
