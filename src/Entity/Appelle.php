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

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombre_appelle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MicroPaiement", inversedBy="appelles")
     */
    private $micropaiment;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $frame;

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

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getNumberOfCalls()
    {
        $number = explode('-',$this->description);
        $value = $number[1];
        return $value;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getNombreAppelle(): ?int
    {
        return $this->nombre_appelle;
    }

    public function setNombreAppelle(int $nombre_appelle): self
    {
        $this->nombre_appelle = $nombre_appelle;

        return $this;
    }

    public function getMicropaiment(): ?MicroPaiement
    {
        return $this->micropaiment;
    }

    public function setMicropaiment(?MicroPaiement $micropaiment): self
    {
        $this->micropaiment = $micropaiment;

        return $this;
    }

    public function __toString()
    {
        return $this->description;
    }

    public function getFrame(): ?string
    {
        return $this->frame;
    }

    public function setFrame(?string $frame): self
    {
        $this->frame = $frame;

        return $this;
    }
}
