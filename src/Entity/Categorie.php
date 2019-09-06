<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=45, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $categorie;

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }
    public function setCategorie(?string $categorie): self
    {
        $this->categorie = $categorie;
        return $this;
    }

}
