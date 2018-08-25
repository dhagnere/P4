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
<<<<<<< HEAD
     * @ORM\OneToMany(targetEntity="App\Entity\Billet", mappedBy="commande", cascade={"persist"})
=======
     * @ORM\OneToMany(targetEntity="App\Entity\Billet", mappedBy="commande_id", cascade={"persist"},)
>>>>>>> d344c7da6b90b5549813c108489ecfaa3934984e
     */
    private $billets;

    public function __construct()
    {
        $this->billets = new ArrayCollection();
    }

    public function getId()
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

    /**
     * @return Collection|Billet[]
     */
    public function getBillets(): Collection
    {
        return $this->billets;
    }

    public function addBillet(Billet $billet): self
    {
        if (!$this->billets->contains($billet)) {
            $this->billets[] = $billet;
            $billet->setCommandeId($this);
        }

        return $this;
    }

    public function removeBillet(Billet $billet): self
    {
        if ($this->billets->contains($billet)) {
            $this->billets->removeElement($billet);
            // set the owning side to null (unless already changed)
            if ($billet->getCommandeId() === $this) {
                $billet->setCommandeId(null);
            }
        }

        return $this;
    }
}
