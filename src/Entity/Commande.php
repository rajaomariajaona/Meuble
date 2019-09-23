<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="commande_ibfk_1", columns={"client_num_client"})})
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_commande", type="date", nullable=false)
     */
    private $dateCommande;

    /**
     * @var bool
     *
     * @ORM\Column(name="livree", type="boolean", nullable=false)
     */
    private $livree;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client_num_client", referencedColumnName="num_client")
     * })
     */
    private $clientNumClient;

    public function getNumCommande(): ?int
    {
        return $this->numCommande;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(?\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getClientNumClient(): ?Client
    {
        return $this->clientNumClient;
    }

    public function setClientNumClient(?Client $clientNumClient): self
    {
        $this->clientNumClient = $clientNumClient;

        return $this;
    }



    /**
     * Get the value of livree
     *
     * @return  bool
     */ 
    public function getLivree()
    {
        return $this->livree;
    }

    /**
     * Set the value of livree
     *
     * @param  bool  $livree
     *
     * @return  self
     */ 
    public function setLivree(bool $livree)
    {
        $this->livree = $livree;

        return $this;
    }
}
