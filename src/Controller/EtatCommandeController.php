<?php

namespace App\Controller;

use App\Entity\EtatCommande;
use App\Repository\EtatCommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RESTBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;

class EtatCommandeController extends AbstractFOSRestController
{
    private $entityManager;
    private $etatRepository;
    public function __construct(EntityManagerInterface $entityManager, EtatCommandeRepository $etatRepository)
    {
        $this -> entityManager = $entityManager;
        $this -> etatRepository = $etatRepository;
    }
    public function getEtatsAction()
    {
        $data = $this -> etatRepository -> findAll();
        return $this -> view($data, Response::HTTP_OK);
    }

    public function getEtatAction(EtatCommande $etat)
    {
        $data = $this -> etatRepository -> find($etat);
        if($data){

            return $this -> view($data, Response::HTTP_OK);
        }else{
            return $this -> view(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }
    }
    /**
     * @RequestParam(name="etat")
     */
    public function postEtatAction(ParamFetcher $paramFetcher)
    {
        $nom = $paramFetcher -> get("etat");
        $etat = new EtatCommande();
        $etat ->setEtatCommande($nom);
        $this -> entityManager -> persist($etat);
        $this -> entityManager -> flush();
        return $this -> view($etat, Response::HTTP_OK);
    }

    /**
     * @RequestParam(name="etat")
     */
    public function putEtatAction(EtatCommande $etatCommande, ParamFetcher $paramFetcher)
    {
        $nom = $paramFetcher -> get("etat");
        $etat = $this -> etatRepository -> find($etatCommande);
        $etat -> setEtatCommande($nom);
        $this -> entityManager -> persist($etat);
        $this -> entityManager -> flush();
        return $this -> view($etat, Response::HTTP_OK);
    }
    public function deleteEtatAction(EtatCommande $etatCommande)
    {
        $etat = $this -> etatRepository -> find($etatCommande);
        $this -> entityManager -> remove($etat);
        $this -> entityManager -> flush();
        return $this -> view($etat, Response::HTTP_OK);
    }
}
