<?php

namespace App\Entity;

use App\Repository\MarcheRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarcheRepository::class)]
class Marche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $lib_marche = null;

    #[ORM\Column]
    private ?int $flag = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_creationM = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_majM = null;

    #[ORM\OneToMany(mappedBy: 'marche', targetEntity: Cours::class)]
    private Collection $cours;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
    }


    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getLibMarche(): ?string
    {
        return $this->lib_marche;
    }

    public function setLibMarche(string $lib_marche): static
    {
        $this->lib_marche = $lib_marche;

        return $this;
    }

    public function getFlag(): ?int
    {
        return $this->flag;
    }

    public function setFlag(int $flag): static
    {
        $this->flag = $flag;

        return $this;
    }

    public function getDateCreationM(): ?\DateTimeInterface
    {
        return $this->date_creationM;
    }

    public function setDateCreationM(\DateTimeInterface $date_creationM): static
    {
        $this->date_creationM = $date_creationM;

        return $this;
    }

    public function getDateMajM(): ?\DateTimeInterface
    {
        return $this->date_majM;
    }

    public function setDateMajM(\DateTimeInterface $date_majM): static
    {
        $this->date_majM = $date_majM;

        return $this;
    }

    /**
     * @return Collection<int, Cours>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): static
    {
        if (!$this->cours->contains($cour)) {
            $this->cours->add($cour);
            $cour->setMarche($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): static
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getMarche() === $this) {
                $cour->setMarche(null);
            }
        }

        return $this;
    }
}
