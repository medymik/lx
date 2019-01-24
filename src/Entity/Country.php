<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 */
class Country
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Appelle", mappedBy="country")
     */
    private $appelles;

    public function __construct()
    {
        $this->appelles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Appelle[]
     */
    public function getAppelles(): Collection
    {
        return $this->appelles;
    }

    public function addAppelle(Appelle $appelle): self
    {
        if (!$this->appelles->contains($appelle)) {
            $this->appelles[] = $appelle;
            $appelle->setCountry($this);
        }

        return $this;
    }

    public function removeAppelle(Appelle $appelle): self
    {
        if ($this->appelles->contains($appelle)) {
            $this->appelles->removeElement($appelle);
            // set the owning side to null (unless already changed)
            if ($appelle->getCountry() === $this) {
                $appelle->setCountry(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
