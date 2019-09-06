<?php

namespace App\Controller;

use App\Entity\Province;
use App\Repository\ProvinceRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;


class ProvinceController extends AbstractFOSRestController
{
    private $entityManager;
    private $provinceRepository;
    public function __construct(EntityManagerInterface $entityManager, ProvinceRepository $provinceRepository)
    {
        $this -> entityManager = $entityManager;
        $this -> provinceRepository = $provinceRepository;
    }
    public function getProvincesAction()
    {
        $data = $this -> provinceRepository -> findAll();
        return $this -> view($data, Response::HTTP_OK);
    }

}
