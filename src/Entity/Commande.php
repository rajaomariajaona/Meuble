<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="fk_commande_user1", columns={"user_id"}), @ORM\Index(name="fk_commande_etat_commande1", columns={"etat_commande"})})
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="num_commande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numCommande;

    /**
     * @var \EtatCommande
     *
     * @ORM\ManyToOne(targetEntity="EtatCommande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etat_commande", referencedColumnName="etat_commande")
     * })
     */
    private $etatCommande;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Meuble", inversedBy="commandeNumCommande")
     * @ORM\JoinTable(name="contient",
     *   joinColumns={
     *     @ORM\JoinColumn(name="commande_num_commande", referencedColumnName="num_commande")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="meuble_num_serie", referencedColumnName="num_serie")
     *   }
     * )
     */
    private $meubleNumSerie;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Client", mappedBy="commandeNumCommande")
     */
    private $clientNumClient;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->meubleNumSerie = new \Doctrine\Common\Collections\ArrayCollection();
        $this->clientNumClient = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getNumCommande(): ?int
    {
        return $this->numCommande;
    }

    public function getEtatCommande(): ?EtatCommande
    {
        return $this->etatCommande;
    }

    public function setEtatCommande(?EtatCommande $etatCommande): self
    {
        $this->etatCommande = $etatCommande;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Meuble[]
     */
    public function getMeubleNumSerie(): Collection
    {
        return $this->meubleNumSerie;
    }

    public function addMeubleNumSerie(Meuble $meubleNumSerie): self
    {
        if (!$this->meubleNumSerie->contains($meubleNumSerie)) {
            $this->meubleNumSerie[] = $meubleNumSerie;
        }

        return $this;
    }

    public function removeMeubleNumSerie(Meuble $meubleNumSerie): self
    {
        if ($this->meubleNumSerie->contains($meubleNumSerie)) {
            $this->meubleNumSerie->removeElement($meubleNumSerie);
        }

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClientNumClient(): Collection
    {
        return $this->clientNumClient;
    }

    public function addClientNumClient(Client $clientNumClient): self
    {
        if (!$this->clientNumClient->contains($clientNumClient)) {
            $this->clientNumClient[] = $clientNumClient;
            $clientNumClient->addCommandeNumCommande($this);
        }

        return $this;
    }

    public function removeClientNumClient(Client $clientNumClient): self
    {
        if ($this->clientNumClient->contains($clientNumClient)) {
            $this->clientNumClient->removeElement($clientNumClient);
            $clientNumClient->removeCommandeNumCommande($this);
        }

        return $this;
    }

}
