<?php

namespace App\Controller;

use App\Entity\Meuble;
use App\Entity\Categorie;
use App\Repository\MeubleRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\RequestParam;

class MeubleController extends AbstractFOSRestController
{
    
    public function __construct(MeubleRepository $meubleRepository, EntityManagerInterface $em)
    {
        $this-> meubleRepository = $meubleRepository;
        $this -> entityManager = $em;
    }
    private $entityManager;

    // CRUD Meubles

    public function getMeublesAction()
    {
        $data = $this -> meubleRepository -> findAll();
        return $data ;
    }
    public function getMeubleAction(Meuble $meuble)
    {
        $data = $this -> meubleRepository -> find($meuble);
        return $this -> view($data, Response::HTTP_OK) ;
    }
    /**
     * @RequestParam(name="numserie")
     * @RequestParam(name="nom")
     * @RequestParam(name="prix")
     * @RequestParam(name="categorie")
     * @RequestParam(name="quantitestock",default=0)
     */
    public function postMeublesAction(ParamFetcher $paramFetcher)
    {
        $numserie = $paramFetcher -> get("numserie");
        $nom = $paramFetcher -> get("nom");
        $prix = $paramFetcher -> get("prix");
        $quantitestock = $paramFetcher -> get("quantitestock");
        $categorie = $this->getDoctrine()->getRepository(Categorie::class) ->find($paramFetcher -> get("categorie"));

        $meuble = new Meuble();
        $meuble -> setNumSerie($numserie)
        -> setNomMeuble($nom)
        ->setPrix($prix)
        ->setCategorie($categorie)
        ->setQuantiteStock($quantitestock);

        $this -> entityManager -> persist($meuble);
        $this -> entityManager -> flush();
        return $this -> view($meuble, Response::HTTP_CREATED) ;
    }
    /**
     * @RequestParam(name="numserie")
     * @RequestParam(name="nom")
     * @RequestParam(name="prix")
     * @RequestParam(name="categorie")
     * 
     */
    public function putMeublesAction(ParamFetcher $paramFetcher, Meuble $meubleModif)
    {
        $meuble = $this -> meubleRepository -> find($meubleModif);
        $numserie = $paramFetcher -> get("numserie");
        $nom = $paramFetcher -> get("nom");
        $prix = $paramFetcher -> get("prix");
        $categorie = $this->getDoctrine()->getRepository(Categorie::class) ->find($paramFetcher -> get("categorie"));

        $meuble ->setNumSerie($numserie)
         -> setNomMeuble($nom)
        ->setPrix($prix)
        ->setCategorie($categorie);
        $this -> entityManager -> persist($meuble);
        $this -> entityManager -> flush();
        return $this -> view($meuble, Response::HTTP_OK) ;
    }
    public function deleteMeublesAction(Meuble $meubleDelete)
    {
        $this -> entityManager -> remove($meubleDelete);
        $this -> entityManager -> flush();
        return $this -> view($meubleDelete, Response::HTTP_OK) ;
    }

    // FIN CRUD Meubles

    
}
