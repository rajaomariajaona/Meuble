<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Meuble
 *
 * @ORM\Table(name="meuble", indexes={@ORM\Index(name="fk_meuble_categorie1", columns={"categorie"})})
 * @ORM\Entity(repositoryClass="App\Repository\MeubleRepository")
 */
class Meuble
{
    /**
     * @var int
     *
     * @ORM\Column(name="num_serie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $numSerie;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_meuble", type="string", length=45, nullable=false)
     */
    private $nomMeuble;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite_stock", type="integer", nullable=false)
     */
    private $quantiteStock;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorie", referencedColumnName="categorie")
     * })
     */
    private $categorie;

    public function setNumSerie(int $numSerie):self
    {
        $this->numSerie = $numSerie;

        return $this;
    }
    
    public function getNumSerie(): ?int
    {
        return $this->numSerie;
    }
    
    public function getNomMeuble(): ?string
    {
        return $this->nomMeuble;
    }
    
    public function setNomMeuble(string $nomMeuble): self
    {
        $this->nomMeuble = $nomMeuble;
        
        return $this;
    }
    
    public function getPrix(): ?float
    {
        return $this->prix;
    }
    
    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        
        return $this;
    }
    
    public function getQuantiteStock(): ?int
    {
        return $this->quantiteStock;
    }
    
    public function setQuantiteStock(?int $quantiteStock): self
    {
        $this->quantiteStock = $quantiteStock;
        
        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }
    
    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;
        
        return $this;
    }  

}
