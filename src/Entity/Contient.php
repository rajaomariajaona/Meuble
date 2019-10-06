<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contient
 *
 * @ORM\Table(name="contient", uniqueConstraints={@ORM\UniqueConstraint(name="commande_num_commande", columns={"commande_num_commande", "meuble_num_serie"})}, indexes={@ORM\Index(name="fk_commande_has_meuble_meuble1", columns={"meuble_num_serie"}), @ORM\Index(name="IDX_DC302E568D055FF0", columns={"commande_num_commande"})})
 * @ORM\Entity(repositoryClass="App\Repository\ContientRepository")
 */
class Contient
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_commande", type="integer", nullable=false)
     */
    private $nombreCommande;

    /**
     * @var \Commande
     *
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="commande_num_commande", referencedColumnName="num_commande")
     * })
     */
    private $commandeNumCommande;

    /**
     * @var \Meuble
     *
     * @ORM\ManyToOne(targetEntity="Meuble")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="meuble_num_serie", referencedColumnName="num_serie")
     * })
     */
    private $meubleNumSerie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreCommande(): ?int
    {
        return $this->nombreCommande;
    }

    public function setNombreCommande(int $nombreCommande): self
    {
        $this->nombreCommande = $nombreCommande;

        return $this;
    }

    public function getCommandeNumCommande(): ?Commande
    {
        return $this->commandeNumCommande;
    }

    public function setCommandeNumCommande(?Commande $commandeNumCommande): self
    {
        $this->commandeNumCommande = $commandeNumCommande;

        return $this;
    }

    public function getMeubleNumSerie(): ?Meuble
    {
        return $this->meubleNumSerie;
    }

    public function setMeubleNumSerie(?Meuble $meubleNumSerie): self
    {
        $this->meubleNumSerie = $meubleNumSerie;

        return $this;
    }
}
