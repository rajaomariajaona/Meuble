<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client", indexes={@ORM\Index(name="fk_client_province", columns={"province_client"})})
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @var int
     *
     * @ORM\Column(name="num_client", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numClient;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_client", type="string", length=45, nullable=false)
     */
    private $nomClient;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_client", type="string", length=45, nullable=false)
     */
    private $prenomClient;

    /**
     * @var string
     *
     * @ORM\Column(name="tel_client", type="string", length=10, nullable=false, options={"fixed"=true})
     */
    private $telClient;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_client", type="string", length=45, nullable=false)
     */
    private $adresseClient;

    /**
     * @var string
     *
     * @ORM\Column(name="cp_client", type="string", length=3, nullable=false, options={"fixed"=true})
     */
    private $cpClient;

    /**
     * @var string
     *
     * @ORM\Column(name="email_client", type="string", length=45, nullable=false)
     */
    private $emailClient;

    /**
     * @var \Province
     *
     * @ORM\ManyToOne(targetEntity="Province")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="province_client", referencedColumnName="province")
     * })
     */
    private $provinceClient;

    public function getNumClient(): ?int
    {
        return $this->numClient;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(string $nomClient): self
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getPrenomClient(): ?string
    {
        return $this->prenomClient;
    }

    public function setPrenomClient(string $prenomClient): self
    {
        $this->prenomClient = $prenomClient;

        return $this;
    }

    public function getTelClient(): ?string
    {
        return $this->telClient;
    }

    public function setTelClient(string $telClient): self
    {
        $this->telClient = $telClient;

        return $this;
    }

    public function getAdresseClient(): ?string
    {
        return $this->adresseClient;
    }

    public function setAdresseClient(string $adresseClient): self
    {
        $this->adresseClient = $adresseClient;

        return $this;
    }

    public function getCpClient(): ?string
    {
        return $this->cpClient;
    }

    public function setCpClient(string $cpClient): self
    {
        $this->cpClient = $cpClient;

        return $this;
    }

    public function getEmailClient(): ?string
    {
        return $this->emailClient;
    }

    public function setEmailClient(string $emailClient): self
    {
        $this->emailClient = $emailClient;

        return $this;
    }

    public function getProvinceClient(): ?Province
    {
        return $this->provinceClient;
    }

    public function setProvinceClient(?Province $provinceClient): self
    {
        $this->provinceClient = $provinceClient;

        return $this;
    }
    public function setNumClient(int $numClient): self
    {
        $this->numClient = $numClient;

        return $this;
    }
}
