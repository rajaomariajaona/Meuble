<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\RequestParam;

class CommandeController extends AbstractFOSRestController
{
    
    public function __construct(CommandeRepository $commandeRepository, EntityManagerInterface $em)
    {
        $this-> commandeRepository = $commandeRepository;
        $this -> entityManager = $em;
    }
    private $entityManager;

    // CRUD Commandes

    public function getCommandesAction()
    {
        $data = $this -> commandeRepository -> findAll();
        return $data ;
    }
    public function getCommandeAction(Commande $commande)
    {
        $data = $this -> commandeRepository -> find($commande);
        return $this -> view($data, Response::HTTP_OK) ;
    }
    /**
     * @RequestParam(name="etatcommande")
     * @RequestParam(name="meubles")
     */
    public function postCommandeAction(ParamFetcher $paramFetcher,Client $clientCommander)
    {
        $client = $clientCommander;
        
        $etatcommande = $paramFetcher -> get("etatcommande");
        $commande = new Commande();
        $commande -> setEtatCommande($etatcommande);

        $client -> addCommandeNumCommande($commande);

        return $this -> view($data, Response::HTTP_OK) ;
    }

    public function deleteCommandesAction(Commande $commandeDelete)
    {
        $commande = $commandeDelete;
        $this -> entityManager -> remove($commande);
        $this -> entityManager -> flush();
        return $this -> view($commande, Response::HTTP_OK) ;
    }
    // FIN CRUD Commandes    
}
