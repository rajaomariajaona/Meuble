<?php

namespace App\Controller;

use App\Entity\Meuble;
use App\Repository\MeubleRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\RequestParam;

class StockController extends AbstractFOSRestController
{
    
    public function __construct(MeubleRepository $meubleRepository, EntityManagerInterface $em)
    {
        $this-> meubleRepository = $meubleRepository;
        $this -> entityManager = $em;
    }
    private $entityManager;

    public function getMeublesdispoAction()
    {
        $meubles = $this -> meubleRepository -> findDispo();

        return $this -> view($meubles, Response::HTTP_OK) ;
    }

    public function getMeublesStockAction(Meuble $meubleStock)
    {
        $meuble = $this -> meubleRepository -> find($meubleStock);

        return $this -> view(["quantiteStock" => $meuble -> getQuantiteStock()], Response::HTTP_OK) ;
    }

    /**
     * @RequestParam(name="quantitestock")
     * 
     */
    public function patchMeublesStockAction(ParamFetcher $paramFetcher, Meuble $meubleStock)
    {
        $quantitestock = $paramFetcher -> get("quantitestock");
        $meuble = $this -> meubleRepository -> find($meubleStock);

        $meuble -> setQuantiteStock($quantitestock);
        $this -> entityManager -> flush();
        return $this -> view($meuble, Response::HTTP_OK) ;
    }
}
