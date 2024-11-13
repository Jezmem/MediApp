<?php
namespace App\Models;

use App\Models\Media;

class Book extends Media {
    private int $pageNumber;

    public function __construct(string $titre, string $auteur, bool $disponible = true, ?int $id = null, int $pageNumber) {
        parent::__construct($titre, $auteur, $disponible, $id);
        $this->pageNumber = $pageNumber;
    }

    public function getPageNumber(): int {
        return $this->pageNumber;
    }

    public function setPageNumber(int $pageNumber): void {
        $this->pageNumber = $pageNumber;
    }

    public function getType(): string {
        return 'Book';
    }
}
