<?php

namespace App\Controller;

use App\Entity\Contient;
use App\Entity\Meuble;
use App\Repository\ContientRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\RequestParam;

class ContientController extends AbstractFOSRestController
{
    public function __construct(ContientRepository $contientRepository, EntityManagerInterface $em)
    {
        $this-> contientRepository = $contientRepository;
        $this -> entityManager = $em;
    }
    private $entityManager;

    // CRUD Contient

    public function getContientsAction()
    {
        $data = $this -> contientRepository -> findAll();
        return $this -> view($data, Response::HTTP_OK) ;
    }
    public function getContientAction(Contient $contient)
    {
        return $this -> view($contient, Response::HTTP_OK) ;
    }


    /**
     * @RequestParam(name="numserie")
     * @RequestParam(name="numcommande")
     * @RequestParam(name="nombrecommande")
     */
    public function postContientAction(ParamFetcher $paramFetcher)
    {
        $contient = new Contient();
        $meuble = $this -> getDoctrine() -> getRepository(Meuble::class) -> find($paramFetcher -> get("numserie"));
        $commande = $this -> getDoctrine() -> getRepository(Meuble::class) -> find($paramFetcher -> get("numcommande"));
        $contient -> setMeubleNumSerie($meuble) 
             -> setCommandeNumCommande($commande)
             -> setNombreCommande($paramFetcher -> get("nombrecommande"))
        ;
        $this -> entityManager -> persist($contient);
        $this -> entityManager -> flush();
        return $this -> view($contient, Response::HTTP_CREATED) ;
    }

    /**
     * @RequestParam(name="numserie")
     * @RequestParam(name="numcommande")
     * @RequestParam(name="nombrecommande")
     */
    public function putContientAction(Contient $contient, ParamFetcher $paramFetcher)
    {
        $meuble = $this -> getDoctrine() -> getRepository(Meuble::class) -> find($paramFetcher -> get("numserie"));
        $commande = $this -> getDoctrine() -> getRepository(Meuble::class) -> find($paramFetcher -> get("numcommande"));

            $contient -> setMeubleNumSerie($meuble)
                -> setCommandeNumCommande($commande)
                -> setNombreCommande($paramFetcher -> get("nombrecommande"))
            ;
            $this -> entityManager -> flush();
            return $this -> view($contient, Response::HTTP_OK);
    }

    

    public function deleteContientsAction(Contient $contient)
    {   
            $this -> entityManager -> remove($contient);
            $this -> entityManager -> flush();
            return $this -> view($contient, Response::HTTP_OK);
    }
    // FIN CRUD Contients
}