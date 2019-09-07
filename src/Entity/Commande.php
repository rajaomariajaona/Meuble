<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="commande_ibfk_1", columns={"client_num_client"}), @ORM\Index(name="fk_commande_etat_comande1", columns={"etat_commande"})})
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_livraison", type="date", nullable=false)
     */
    private $dateLivraison;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_paiement", type="date", nullable=false)
     */
    private $datePaiement;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client_num_client", referencedColumnName="num_client")
     * })
     */
    private $clientNumClient;

    /**
     * @var \EtatCommande
     *
     * @ORM\ManyToOne(targetEntity="EtatCommande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etat_commande", referencedColumnName="etat_commande")
     * })
     */
    private $etatCommande;

    public function getNumCommande(): ?int
    {
        return $this->numCommande;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->dateLivraison;
    }

    public function setDateLivraison(\DateTimeInterface $dateLivraison): self
    {
        $this->dateLivraison = $dateLivraison;

        return $this;
    }

    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(\DateTimeInterface $datePaiement): self
    {
        $this->datePaiement = $datePaiement;

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

    public function getEtatCommande(): ?EtatCommande
    {
        return $this->etatCommande;
    }

    public function setEtatCommande(?EtatCommande $etatCommande): self
    {
        $this->etatCommande = $etatCommande;

        return $this;
    }

    public function setNumCommande(int $numCommande): self
    {
        $this->numCommande = $numCommande;

        return $this;
    }
}
