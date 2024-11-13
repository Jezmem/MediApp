<?php

namespace App\Models;

class Media {
    protected ?int $id;
    protected string $titre;
    protected string $auteur;
    protected bool $disponible;

    public function __construct(string $titre, string $auteur, bool $disponible = true, ?int $id = null) {
        $this->id = $id;
        $this->titre = $titre;
        $this->auteur = $auteur;
        $this->disponible = $disponible;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function getAuteur(): string {
        return $this->auteur;
    }

    public function isDisponible(): bool {
        return $this->disponible;
    }

    public function setTitre(string $titre): void {
        $this->titre = $titre;
    }

    public function setAuteur(string $auteur): void {
        $this->auteur = $auteur;
    }

    public function setDisponible(bool $disponible): void {
        $this->disponible = $disponible;
    }

    public function getType(): string {
        return 'Media'; 
    }
}
