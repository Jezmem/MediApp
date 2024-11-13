<?php

namespace App\Database;

use App\Models\Album;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Media;
use App\Models\Movie;

final class MediaDatabase
{
    private static function databaseName(): string
    {
        return 'mediapp';
    }

    public static function add(Media $media): bool
    {
        $connexion = Database::getInstance();
        
        // Insérer les informations de base dans la table `media`
        $request = $connexion->prepare('INSERT INTO media (titre, auteur, disponible) VALUES (:titre, :auteur, :disponible);');
        
        $mediaTitre = $media->getTitre();
        $mediaAuteur = $media->getAuteur();
        $mediaDisponible = $media->isDisponible();
        
        $request->bindParam(':titre', $mediaTitre);
        $request->bindParam(':auteur', $mediaAuteur);
        $request->bindParam(':disponible', $mediaDisponible, \PDO::PARAM_BOOL);
        
        // Exécuter la requête pour la table media
        if ($request->execute()) {
            // Récupérer l'ID du dernier média ajouté
            $mediaId = $connexion->lastInsertId();
            
            // Vérifier le type de média et insérer dans la table correspondante
            if ($media instanceof Book) {
                $bookRequest = $connexion->prepare('INSERT INTO books (media_id, page_number) VALUES (:media_id, :page_number);');
                $pageNumber = $media->getPageNumber();
                $bookRequest->bindParam(':media_id', $mediaId);
                $bookRequest->bindParam(':page_number', $pageNumber, \PDO::PARAM_INT);
                return $bookRequest->execute();
                
            } elseif ($media instanceof Movie) {
                $movieRequest = $connexion->prepare('INSERT INTO movies (media_id, duration, genre) VALUES (:media_id, :duration, :genre);');
                $duration = $media->getDuration();
                $genre = $media->getGenre();
                $movieRequest->bindParam(':media_id', $mediaId);
                $movieRequest->bindParam(':duration', $duration);
                $movieRequest->bindParam(':genre', $genre);
                return $movieRequest->execute();
                
            } elseif ($media instanceof Album) {
                $albumRequest = $connexion->prepare('INSERT INTO albums (media_id, song_number, editor) VALUES (:media_id, :song_number, :editor);');
                $songNumber = $media->getSongNumber();
                $editor = $media->getEditor();
                $albumRequest->bindParam(':media_id', $mediaId);
                $albumRequest->bindParam(':song_number', $songNumber, \PDO::PARAM_INT);
                $albumRequest->bindParam(':editor', $editor);
                return $albumRequest->execute();
            }
        }
        
        return false; // En cas d'échec
    }

    public function findMediaById($id)
    {
        if (!is_int($id) || $id <= 0) {
            return null;
        }
        $connexion = Database::getInstance();

        $query = "SELECT * FROM media WHERE id = :id";

        $stmt = $connexion->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $media = null;

        switch ($data['type']) {
            case 'book':
                $media = new Book($data['id'], $data['titre'], $data['auteur'], $data['disponible'], $data['pageNumber']);
                break;
            case 'movie':
                $media = new Movie($data['id'], $data['titre'], $data['auteur'], $data['disponible'], $data['duration'], $data['genre']);
                break;
            case 'album':
                $media = new Album($data['id'], $data['titre'], $data['auteur'], $data['disponible'], $data['songNumber'], $data['editor']);
                break;
            default:
                return null; 
        }

        return $media;
    }



    public static function findBooks(): array
    {
        $connection = Database::getInstance();
        $query = $connection->prepare("
            SELECT media.* FROM media
            JOIN books ON media.id = books.media_id
            ORDER BY media.titre;
        ");
        $query->execute();
        
        $results = $query->fetchAll();
        $books = [];
        
        foreach ($results as $result) {
            $books[] = new Media($result['titre'], $result['auteur'], (bool)$result['disponible'], $result['id']);
        }

        return $books;
    }

    public static function findMovies(): array
    {
        $connection = Database::getInstance();
        $query = $connection->prepare("
            SELECT media.* FROM media
            JOIN movies ON media.id = movies.media_id
            ORDER BY media.titre;
        ");
        $query->execute();
        
        $results = $query->fetchAll();
        $movies = [];
        
        foreach ($results as $result) {
            $movies[] = new Media($result['titre'], $result['auteur'], (bool)$result['disponible'], $result['id']);
        }

        return $movies;
    }

    public static function findAlbums(): array
    {
        $connection = Database::getInstance();
        $query = $connection->prepare("
            SELECT media.* FROM media
            JOIN albums ON media.id = albums.media_id
            ORDER BY media.titre;
        ");
        $query->execute();
        
        $results = $query->fetchAll();
        $albums = [];
        
        foreach ($results as $result) {
            $albums[] = new Media($result['titre'], $result['auteur'], (bool)$result['disponible'], $result['id']);
        }

        return $albums;
    }


    public static function findAll(): array
    {
        $connection = Database::getInstance();
        $query = $connection->prepare("SELECT * FROM " . self::databaseName() . " ORDER BY titre;");
        $query->execute();

        $results = $query->fetchAll();
        $medias = [];

        foreach ($results as $result) {
            $medias[] = new Media($result['titre'], $result['auteur'], (bool)$result['disponible'], $result['id']);
        }

        return $medias;
    }

    public static function edit(Media $media): bool
    {
        $connexion = Database::getInstance();
        $request = $connexion->prepare('UPDATE media SET titre = :titre, auteur = :auteur, disponible = :disponible WHERE id = :id;');

        $mediaId = $media->getId();
        $mediaTitre = $media->getTitre();
        $mediaAuteur = $media->getAuteur();
        $mediaDisponible = $media->isDisponible();

        $request->bindParam(':id', $mediaId, \PDO::PARAM_INT);
        $request->bindParam(':titre', $mediaTitre);
        $request->bindParam(':auteur', $mediaAuteur);
        $request->bindParam(':disponible', $mediaDisponible, \PDO::PARAM_BOOL);

        return $request->execute();
    }

    public function save($media)
    {
        $connexion = Database::getInstance();

        if ($media->getId() === null) {
            $query = "INSERT INTO media (titre, auteur, disponible, type) VALUES (:titre, :auteur, :disponible, :type)";
            
            $stmt = $connexion->prepare($query);
            $stmt->bindParam(':titre', $media->getTitre(), \PDO::PARAM_STR);
            $stmt->bindParam(':auteur', $media->getAuteur(), \PDO::PARAM_STR);
            $stmt->bindParam(':disponible', $media->isDisponible(), \PDO::PARAM_BOOL);
            $stmt->bindParam(':type', $media->getType(), \PDO::PARAM_STR);

            $stmt->execute();

            $media->setId($connexion->lastInsertId());

            return true;
        } else {
            $query = "UPDATE media SET titre = :titre, auteur = :auteur, disponible = :disponible, type = :type WHERE id = :id";

            $stmt = $connexion->prepare($query);
            $stmt->bindParam(':titre', $media->getTitre(), \PDO::PARAM_STR);
            $stmt->bindParam(':auteur', $media->getAuteur(), \PDO::PARAM_STR);
            $stmt->bindParam(':disponible', $media->isDisponible(), \PDO::PARAM_BOOL);
            $stmt->bindParam(':type', $media->getType(), \PDO::PARAM_STR); 
            $stmt->bindParam(':id', $media->getId(), \PDO::PARAM_INT);

            return $stmt->execute();
        }
    }


    public static function find(int $id)
    {
        $connection = Database::getInstance();
    
        $query = $connection->prepare("SELECT * FROM media WHERE id = :id");
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_ASSOC);
    
        if (!$result) {
            return null;
        }
    
        // Déterminer le type de média et récupérer les données spécifiques
        switch ($result['type']) {
            case 'book':
                $query = $connection->prepare("SELECT page_number FROM books WHERE media_id = :id");
                $query->bindParam(':id', $id, \PDO::PARAM_INT);
                $query->execute();
                $specificData = $query->fetch(\PDO::FETCH_ASSOC);
                return new Book($result['titre'], $result['auteur'], $result['disponible'], $id, $specificData['page_number']);
            
            case 'movie':
                $query = $connection->prepare("SELECT duration, genre FROM movies WHERE media_id = :id");
                $query->bindParam(':id', $id, \PDO::PARAM_INT);
                $query->execute();
                $specificData = $query->fetch(\PDO::FETCH_ASSOC);
                
                return new Movie($result['titre'], $result['auteur'], $result['disponible'], $id, (float)$specificData['duration'], (string)$specificData['duration']);
            
            case 'album':
                $query = $connection->prepare("SELECT song_number, editor FROM albums WHERE media_id = :id");
                $query->bindParam(':id', $id, \PDO::PARAM_INT);
                $query->execute();
                $specificData = $query->fetch(\PDO::FETCH_ASSOC);
                return new Album($result['titre'], $result['auteur'], $result['disponible'], $id, (int)$specificData['song_number'], $specificData['editor']);
            
            default:
                return null;
        }
    }

    public static function delete(int $id): bool
    {
        $connexion = Database::getInstance();
        $request = $connexion->prepare('DELETE FROM ' . self::databaseName() . ' WHERE id = :id;');
        $request->bindParam(':id', $id, \PDO::PARAM_INT);
    
        return $request->execute();
    }
    

    public static function updateAvailability(int $id, bool $disponible): void {
        $connection = Database::getInstance();
    
        $query = $connection->prepare("UPDATE media SET disponible = :disponible WHERE id = :id");
        $query->bindParam(':disponible', $disponible, \PDO::PARAM_BOOL);
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        if ($query->execute()) {
            echo "Mise à jour réussie";
        } else {
            echo "Erreur de mise à jour";
        }
    }

    // Fonction pour rechercher un média par titre 
    public static function searchMediaByTitle(string $title): array
    {
        $connexion = Database::getInstance();
        $query = $connexion->prepare("SELECT * FROM " . self::databaseName() . " WHERE titre LIKE :title ORDER BY titre;");
        $searchTitle = '%' . $title . '%';
        $query->bindParam(':title', $searchTitle, \PDO::PARAM_STR);
        $query->execute();

        $results = $query->fetchAll();
        $medias = [];

        foreach ($results as $result) {
            $medias[] = new Media($result['titre'], $result['auteur'], (bool)$result['disponible'], $result['id']);
        }

        return $medias;
    }
}
