<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtatCommande
 *
 * @ORM\Table(name="etat_commande")
 * @ORM\Entity(repositoryClass="App\Repository\EtatCommandeRepository")
 */
class EtatCommande
{
    /**
     * @var string
     *
     * @ORM\Column(name="etat_commande", type="string", length=20, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $etatCommande;

    public function getEtatCommande(): ?string
    {
        return $this->etatCommande;
    }

    public function setEtatCommande(?string $etatCommande): self
    {
        $this ->etatCommande = $etatCommande;

        return $this;
    }

}
