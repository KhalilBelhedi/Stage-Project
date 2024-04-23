<?php

namespace App\Entity;

use App\Repository\DeviseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeviseRepository::class)]
class Devise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lib_devise = null;

    

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_creation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_maj = null;

    #[ORM\Column(length: 1)]
    private ?string $flag = null;

    #[ORM\OneToMany(mappedBy: 'devise', targetEntity: Cours::class)]
    private Collection $cours;

    
    public function __construct()
    {
        $this->cours = new ArrayCollection();
    }

   
    

 


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibDevise(): ?string
    {
        return $this->lib_devise;
    }

    public function setLibDevise(string $lib_devise): static
    {
        $this->lib_devise = $lib_devise;

        return $this;
    }

    

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateMaj(): ?\DateTimeInterface
    {
        return $this->date_maj;
    }

    public function setDateMaj(\DateTimeInterface $date_maj): static
    {
        $this->date_maj = $date_maj;

        return $this;
    }

    public function getFlag(): ?string
    {
        return $this->flag;
    }

    public function setFlag(string $flag): static
    {
        $this->flag = $flag;

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
            $cour->setDevise($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): static
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getDevise() === $this) {
                $cour->setDevise(null);
            }
        }

        return $this;
    }

    
  

}
