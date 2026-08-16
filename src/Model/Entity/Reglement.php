<?php

class Reglement {
    private ?int $id;
    private string $nomOperateur;

        public function __construct(?int $id = null,string $nomOperateur = '' ) {
            $this->id = $id;
        $this->nomOperateur = $nomOperateur;
      }
    public function setId(int $id): void 
{
    $this->id = $id;
}
    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getNomOperateur(): string  {
         return $this->nomOperateur;
    }

    public function setNomOperateur(string $nomOperateur): void 
    {
        $this->nomOperateur = $nomOperateur;
    }
}