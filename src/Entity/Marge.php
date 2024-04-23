<?php

namespace App\Entity;

use App\Repository\MargeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MargeRepository::class)]
class Marge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $marge_achat = null;

    #[ORM\Column]
    private ?float $marge_vente = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_mise_jour = null;

    #[ORM\OneToOne(inversedBy: 'marge', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cours $cours = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMargeAchat(): ?float
    {
        return $this->marge_achat;
    }

    public function setMargeAchat(float $marge_achat): static
    {
        $this->marge_achat = $marge_achat;

        return $this;
    }

    public function getMargeVente(): ?float
    {
        return $this->marge_vente;
    }

    public function setMargeVente(float $marge_vente): static
    {
        $this->marge_vente = $marge_vente;

        return $this;
    }

    public function getDateMiseJour(): ?\DateTimeInterface
    {
        return $this->date_mise_jour;
    }

    public function setDateMiseJour(\DateTimeInterface $date_mise_jour): static
    {
        $this->date_mise_jour = $date_mise_jour;

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(Cours $cours): static
    {
        $this->cours = $cours;

        return $this;
    }
}
