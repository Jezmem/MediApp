<?php

namespace App\Controller;

use App\Database\MediaDatabase;
use App\Models\Media;
use App\Models\Book;
use App\Models\Movie;
use App\Models\Album;


class MediaController extends AbstractController
{
    private $mediaDatabase;

    public function __construct()
    {
        $this->mediaDatabase = new MediaDatabase();
    }

    // Affiche le tableau de bord
    public function index(): string
    {
        $books = $this->mediaDatabase->findBooks();
        $movies = $this->mediaDatabase->findMovies();
        $albums = $this->mediaDatabase->findAlbums();

        return $this->render('dashboard/dashboard.php', [
            'books' => $books,
            'albums' => $albums,
            'movies' => $movies,
        ]);
    }
    // Ajoute un nouveau média
    public function addMedia()
    {
        return $this->render('media/add.php');
    }

    public function saveMedia()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = $_POST['titre'] ?? null;
            $auteur = $_POST['auteur'] ?? null;
            $type = $_POST['type'] ?? null;
            $disponible = isset($_POST['disponible']) ? true : false;
            $media = null;
            switch ($type) {
                case 'book':
                    $pageNumber = $_POST['page_number'] ?? 0;
                    $media = new Book($titre, $auteur, $disponible, null, $pageNumber);
                    break;
                case 'movie':
                    $duration = $_POST['duration'] ?? 0;
                    $genre = $_POST['genre'] ?? null;
                    $media = new Movie($titre, $auteur, $disponible, null, $duration, $genre);
                    break;
                case 'album':
                    $songNumber = $_POST['song_number'] ?? 0;
                    $editor = $_POST['editor'] ?? null;
                    $media = new Album($titre, $auteur, $disponible, null, $songNumber, $editor);
                    break;
                default:
                    echo "Type de média non reconnu.";
                    return;
            }
            
            if ($media && MediaDatabase::add($media)) {
                header('Location: /dashboard');
                exit();
            } else {
                echo "Erreur lors de l'ajout du média.";
            }
        }

        require_once '../src/vew/add.php';
    }

    

    public function edit($id)
    {
        $media = $this->mediaDatabase->findMediaById($id);
    
        if (!$media) {
            return $this->render('/dashboard');
        }
    
        require_once 'views/editMedia.php';
    }

    public function update()
    {
        $id = $_POST['media_id'];
        $titre = $_POST['titre'];
        $auteur = $_POST['auteur'];
        $disponible = isset($_POST['disponible']) ? (bool) $_POST['disponible'] : false;

        $media = $this->mediaDatabase->findMediaById($id);
        if ($media) {
            $media->setTitre($titre);
            $media->setAuteur($auteur);
            $media->setDisponible($disponible);

            if ($media instanceof Book) {
                $media->setPageNumber($_POST['pageNumber']);
            } elseif ($media instanceof Movie) {
                $media->setDuration($_POST['duration']);
                $media->setGenre($_POST['genre']);
            } elseif ($media instanceof Album) {
                $media->setSongNumber($_POST['songNumber']);
                $media->setEditor($_POST['editor']);
            }

            $this->mediaDatabase->save($media);

            // Rediriger vers la page des détails
            return $this->render('/media/details/' . $id);
        }

        return $this->render('/dashboard');
    }

    

    // Supprime un média
    public function delete($id): bool
    {
        if ($id && is_numeric($id)) {
            return $this->mediaDatabase->delete((int)$id); 
        }

        return false;
    }

    public function search()
    {
        $title = $_GET['title'] ?? ''; 
        $results = $this->mediaDatabase->searchMediaByTitle($title); 
            
        return $this->render('dashboard/dashboard.php', [
            'results' => $results,
            'searchQuery' => $title
        ]);
    }

    public function details()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if (!$id) {
            throw new \Exception("ID du média manquant");
        }

        $media = $this->mediaDatabase->find($id);
        if (!$media) {
            throw new \Exception("Média introuvable");
        }

        return $this->render('media/details.php', [
            'media' => $media,
            'id' => $id
        ]);
    }

    public function toggleAvailability() {
        $mediaId = $_POST['media_id'] ?? null;

        if ($mediaId === null) {
            echo "Erreur lors de la modification de l'état du media.";
        }

        $media = MediaDatabase::find((int)$mediaId);

        if ($media) {
            $newStatus = !$media->isDisponible();
            $media->setDisponible($newStatus);

            MediaDatabase::updateAvailability((int)$mediaId, $newStatus);
        }

        header("Location: /media/details?id=" . $mediaId);
        exit;
    }


}
