<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $coursBH_achat = null;

    #[ORM\Column]
    private ?float $coursBH_vente = null;

    #[ORM\Column(nullable: true)]
    private ?float $coursMoy = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

   
    #[ORM\Column]
    private ?int $etat = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?Marche $marche = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?Devise $devise = null;

    #[ORM\OneToOne(mappedBy: 'cours', cascade: ['persist', 'remove'])]
    private ?Marge $marge = null;

    #[ORM\Column]
    private ?float $coursBCT_achat = null;

    #[ORM\Column]
    private ?float $coursBCT_vente = null;

   

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoursBHAchat(): ?float
    {
        return $this->coursBH_achat;
    }

    public function setCoursBHAchat(float $coursBH_achat): static
    {
        $this->coursBH_achat = $coursBH_achat;

        return $this;
    }

    public function getCoursBHVente(): ?float
    {
        return $this->coursBH_vente;
    }

    public function setCoursBHVente(float $coursBH_vente): static
    {
        $this->coursBH_vente = $coursBH_vente;

        return $this;
    }

    public function getCoursMoy(): ?float
    {
        return $this->coursMoy;
    }

    public function setCoursMoy(?float $coursMoy): static
    {
        $this->coursMoy = $coursMoy;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

   
    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getMarche(): ?Marche
    {
        return $this->marche;
    }

    public function setMarche(?Marche $marche): static
    {
        $this->marche = $marche;

        return $this;
    }

    public function getDevise(): ?Devise
    {
        return $this->devise;
    }

    public function setDevise(?Devise $devise): static
    {
        $this->devise = $devise;

        return $this;
    }

    public function getMarge(): ?Marge
    {
        return $this->marge;
    }

    public function setMarge(Marge $marge): static
    {
        // set the owning side of the relation if necessary
        if ($marge->getCours() !== $this) {
            $marge->setCours($this);
        }

        $this->marge = $marge;

        return $this;
    }

    public function getCoursBCTAchat(): ?float
    {
        return $this->coursBCT_achat;
    }

    public function setCoursBCTAchat(float $coursBCT_achat): static
    {
        $this->coursBCT_achat = $coursBCT_achat;

        return $this;
    }

    public function getCoursBCTVente(): ?float
    {
        return $this->coursBCT_vente;
    }

    public function setCoursBCTVente(float $coursBCT_vente): static
    {
        $this->coursBCT_vente = $coursBCT_vente;

        return $this;
    }

  
}
