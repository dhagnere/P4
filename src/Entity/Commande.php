<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
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
    private $mail;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_visit;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_tickets;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $halfday;

    /**
     * @ORM\Column(type="integer" , nullable=true)
     */
        private $categorie;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Billet", mappedBy="commande", cascade={"persist"})
     */
    private $billets;

    /**
     * @ORM\Column(type="integer" , nullable=true)
     */
    private $prixTotal;


    public function __construct()
    {
        $this->billets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getDateVisit(): ?\DateTimeInterface
    {
        return $this->date_visit;
    }

    public function setDateVisit(\DateTimeInterface $date_visit): self
    {
        $this->date_visit = $date_visit;

        return $this;
    }

    public function getNbTickets(): ?int
    {
        return $this->nb_tickets;
    }

    public function setNbTickets(int $nb_tickets): self
    {
        $this->nb_tickets = $nb_tickets;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getHalfday(): ?bool
    {
        return $this->halfday;
    }

    public function setHalfday(bool $halfday): self
    {
        $this->halfday = $halfday;

        return $this;
    }

    /**
     * @return Collection|billet[]
     */
    public function getBillets(): Collection
    {
        return $this->billets;
    }

    public function addBillet(billet $billet): self
    {
        if (!$this->billets->contains($billet)) {
            $this->billets[] = $billet;
            $billet->setCommande($this);
        }

        return $this;
    }

    public function removeBillet(billet $billet): self
    {
        if ($this->billets->contains($billet)) {
            $this->billets->removeElement($billet);
            // set the owning side to null (unless already changed)
            if ($billet->getCommande() === $this) {
                $billet->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCategorie(): ?int
    {
        return $this->categorie;
    }

    public function setCategorie(?int $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getPrixTotal()
    {
        $prixTotal = 0;
        foreach ($this->getBillets() as $billet){

            $prixTotal += $billet->getTarif();
        }
        return $prixTotal;
    }

    public function setPrixTotal(?int $prixTotal)
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

}
