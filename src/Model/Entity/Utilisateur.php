<?php
class Utilisateur 
{
    private ?int $id;
    private string $prenom;
    private string $nom;
    private string $email;
    private string $motDePasse;
    private ?Role $role;

    public function __construct(?int $id = null,string $prenom = '',string $nom = '',string $email = '',string $motDePasse = '',?Role $role = null) 
    {
        $this->id = $id;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->email = $email;
        $this->motDePasse = $motDePasse;
        $this->role = $role;
    }
    public function setId(int $id): void 
{
    $this->id = $id;
}
    public function getId(): ?int {
        return $this->id;
    }

    public function getPrenom(): string {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void {
        $this->prenom = $prenom;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getMotDePasse(): string {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): void {
        $this->motDePasse = $motDePasse;
    }

    public function getRole(): ?Role {
        return $this->role;
    }

    public function setRole(?Role $role): void {
        $this->role = $role;
    }

}