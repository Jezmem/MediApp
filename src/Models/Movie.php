<?php
namespace App\Models;

use App\Models\Media;

class Movie extends Media {
    private float $duration;
    private string $genre;

    public function __construct(string $titre, string $auteur, bool $disponible = true, ?int $id = null, float $duration, string $genre) {
        parent::__construct($titre, $auteur, $disponible, $id);
        $this->duration = $duration;
        $this->genre = $genre; 
    }

    public function getDuration(): float {
        return $this->duration;
    }

    public function getGenre(): string {
        return $this->genre; 
    }

    public function setDuration(float $duration): void {
        $this->duration = $duration;
    }

    public function setGenre(string $genre): void { 
        $this->genre = $genre;
    }

    public function getType(): string {
        return 'Movie';
    }
}
