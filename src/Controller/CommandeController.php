<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Meuble;
use App\Repository\CommandeRepository;
use App\Repository\ContientRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\RequestParam;

class CommandeController extends AbstractFOSRestController
{
    private $contientRepository;
    public function __construct(ContientRepository $contientRepository, CommandeRepository $commandeRepository, EntityManagerInterface $em)
    {
        $this -> contientRepository = $contientRepository;
        $this-> commandeRepository = $commandeRepository;
        $this -> entityManager = $em;
    }
    private $entityManager;

    // CRUD Commandes

    public function getCommandesAction()
    {
        $data = $this -> contientRepository -> findAll();
        return $this -> view($data, Response::HTTP_OK) ;
    }
    public function getCommandeAction(Commande $commande)
    {
        $data = $this ->contientRepository -> findBy(['commandeNumCommande' => $commande ]);
        return $this -> view($data, Response::HTTP_OK) ;
    }

    public function getClientCommandesAction(Client $clientCommander)
    {
        $data = $this -> contientRepository -> findBy(['numClient' => 1]);
        return $this -> view($data, Response::HTTP_OK) ;
    }
    public function getClientCommandeAction(Client $clientCommander,Commande $commande)
    {
        $data = $this -> contientRepository -> findBy(['numClient' => $clientCommander, 'commandeNumCommande' => $commande ]);
        return $this -> view($data, Response::HTTP_OK) ;
    }
    /**
     * @RequestParam(name="etatcommande")
     * @RequestParam(name="meubles")
     */
    public function postClientCommandeAction(Client $clientCommander, ParamFetcher $paramFetcher)
    {
        $client = $clientCommander;
        
        $etatcommande = $paramFetcher -> get("etatcommande");
        $commande = new Commande();
        $commande -> setEtatCommande($etatcommande);
        $client -> addCommandeNumCommande($commande);
        return $this -> view($commande, Response::HTTP_OK) ;
    }

    public function getCommandeMeublesAction(Commande $commande)
    {
        $meubles = $commande -> getMeubleNumSerie();
        return $this -> view($meubles, Response::HTTP_OK);
    }
    /**
     * @RequestParam(name="meuble")
     */
    public function postCommandeMeublesAction(Commande $commande, ParamFetcher $paramFetcher)
    {
        $numserie = $paramFetcher -> get("meuble");
        $meuble = $this -> getDoctrine() -> getRepository(Meuble::class) -> find($numserie);
        $commande -> addMeubleNumSerie($meuble);
        return $this -> view($commande, Response::HTTP_OK);
    }
    /**
     * @RequestParam(name="meuble")
     */
    public function putCommandeMeubleAction(Commande $commande,Meuble $meubleAncien,  ParamFetcher $paramFetcher)
    {
        $numserie = $paramFetcher -> get("meuble");
        $meuble = $this -> getDoctrine() -> getRepository(Meuble::class) -> find($numserie);

        $commande ->removeMeubleNumSerie($meubleAncien);
        $commande ->addMeubleNumSerie($meuble);
        return $this -> view($commande, Response::HTTP_OK);
    }
    public function deleteCommandeMeubleAction(Commande $commande, Meuble $meuble, ParamFetcher $paramFetcher)
    {
        $nom = $paramFetcher -> get("meuble");
        $commande -> addMeubleNumSerie($meuble);
        return $this -> view($commande, Response::HTTP_OK);
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