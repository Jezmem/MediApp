<?php
namespace App\Models;

use App\Models\Media; 

class Album extends Media {
    private int $songNumber;
    private string $editor;

    public function __construct(string $titre, string $auteur, bool $disponible = true, ?int $id = null, int $songNumber, string $editor) {
        parent::__construct($titre, $auteur, $disponible, $id);
        $this->songNumber = $songNumber;
        $this->editor = $editor;
    }

    // Getters
    public function getSongNumber(): int {
        return $this->songNumber;
    }

    public function getEditor(): string {
        return $this->editor;
    }

    // Setters
    public function setSongNumber(int $songNumber): void {
        $this->songNumber = $songNumber;
    }

    public function setEditor(string $editor): void {
        $this->editor = $editor;
    }

    public function getType(): string {
        return 'Album';
    }
}
