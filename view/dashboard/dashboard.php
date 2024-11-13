<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - MediApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/path/to/your/styles.css">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Bienvenue sur MediApp</h1>

        <!-- Formulaire de recherche -->
        <div class="mb-5">
            <form class="d-flex justify-content-center" action="/media/search" method="GET">
                <div class="input-group w-50">
                    <input type="text" class="form-control" id="search" name="title" placeholder="Rechercher un média par titre" required>
                    <button class="btn btn-primary" type="submit">Rechercher</button>
                </div>
            </form>
        </div>

        <a href="/media/add">
            <button type="button">Ajouter un média</button>
        </a>

        <h2 class="text-center">Liste des médias</h2>

        <!-- Affichage des Livres -->

        <?php if (!empty($books)): ?>
            <h3 class="mt-4">Livres</h3>
            <ul class="list-group">
                <?php foreach ($books as $book): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="/media/details?id=<?= $book->getId() ?>" class="text-decoration-none">
                            <strong><?= $book->getTitre() ?></strong> par <?= $book->getAuteur() ?>
                        </a>
                        <span class="badge <?= $book->isDisponible() ? 'bg-success' : 'bg-danger' ?>">
                            <?= $book->isDisponible() ? 'Disponible' : 'Emprunté' ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Affichage des Films -->
        <?php if (!empty($movies)): ?>
            <h3 class="mt-4">Films</h3>
            <ul class="list-group">
                <?php foreach ($movies as $movie): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="/media/details?id=<?= $movie->getId() ?>" class="text-decoration-none">
                            <strong><?= $movie->getTitre() ?></strong> par <?= $movie->getAuteur() ?>
                        </a>
                        <span class="badge <?= $movie->isDisponible() ? 'bg-success' : 'bg-danger' ?>">
                            <?= $movie->isDisponible() ? 'Disponible' : 'Emprunté' ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Affichage des Albums -->
        <?php if (!empty($albums)): ?>
            <h3 class="mt-4">Albums</h3>
            <ul class="list-group">
                <?php foreach ($albums as $album): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="/media/details?id=<?= $album->getId() ?>" class="text-decoration-none">
                            <strong><?= $album->getTitre() ?></strong> par <?= $album->getAuteur() ?>
                        </a>
                        <span class="badge <?= $album->isDisponible() ? 'bg-success' : 'bg-danger' ?>">
                            <?= $album->isDisponible() ? 'Disponible' : 'Emprunté' ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <?php if (!empty($results)): ?>
        <h3 class="mt-4">Résultats de recherche pour "<?php echo $searchQuery; ?>"</h3>
        <ul class="list-group">
            <?php foreach ($results as $media): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="/media/details?id=<?= $media->getId() ?>" class="text-decoration-none">
                        <strong><?= $media->getTitre() ?></strong> par <?= $media->getAuteur() ?>
                    </a>
                    <span class="badge <?= $media->isDisponible() ? 'bg-success' : 'bg-danger' ?>">
                        <?= $media->isDisponible() ? 'Disponible' : 'Emprunté' ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
