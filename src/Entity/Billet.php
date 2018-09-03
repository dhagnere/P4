<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BilletRepository")
 */
class Billet
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
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $discount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commande", inversedBy="billets")$
    */
    private $commande;

    /**
     * @ORM\Column(type="string")
     */
    private $codeBillet;

    /**
     * @ORM\Column(type="string")
     */
    private $tarif;


    /**
     * @ORM\Column(type="integer")
     */
    private $categorie;

    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }


    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCommande()
    {
        return $this->commande;
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getDiscount(): ?bool
    {
        return $this->discount;
    }

    public function setDiscount(?bool $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getCommandeId(): ?Commande
    {
        return $this->commande;
    }

    public function setCommandeId(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getCodeBillet()
    {
        return $this->codeBillet;
    }

    public function setCodeBillet(string $codeBillet)
    {
        $this->codeBillet=$codeBillet;
    }

    public function setBillet($billet)
    {
        $this->commande=$billet;
    }

    /**
     * @return mixed
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * @param mixed $tarif
     */
    public function setTarif($tarif): void
    {
        $this->tarif = $tarif;
    }

    /**
     * @param mixed $commande
     */
    public function setCommande($commande): void
    {
        $this->commande = $commande;
    }
}

