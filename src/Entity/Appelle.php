<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AppelleRepository")
 */
class Appelle
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
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pricecall;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idd;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idp;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="appelles")
     */
    private $country;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPricecall(): ?string
    {
        return $this->pricecall;
    }

    public function setPricecall(string $pricecall): self
    {
        $this->pricecall = $pricecall;

        return $this;
    }

    public function getIdd(): ?string
    {
        return $this->idd;
    }

    public function setIdd(string $idd): self
    {
        $this->idd = $idd;

        return $this;
    }

    public function getIdp(): ?string
    {
        return $this->idp;
    }

    public function setIdp(string $idp): self
    {
        $this->idp = $idp;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }
}