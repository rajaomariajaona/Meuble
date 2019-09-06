<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Province
 *
 * @ORM\Table(name="province")
 * @ORM\Entity(repositoryClass="App\Repository\ProvinceRepository")
 */
class Province
{
    /**
     * @var string
     *
     * @ORM\Column(name="province", type="string", length=45, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $province;

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(?string $province): self
    {
        $this->province = $province;

        return $this;
    }

}
