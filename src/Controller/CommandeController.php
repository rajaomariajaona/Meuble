<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Contient;
use App\Entity\EtatCommande;
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
        $commandes = $this -> commandeRepository -> findBy(["clientNumClient" => $clientCommander]);
        return $this -> view($commandes, Response::HTTP_OK);
    }
    public function getClientCommandeMeublesAction(Client $clientCommander,Commande $commande)
    {   
        if($clientCommander == $commande -> getClientNumClient()){
            $meubles = $this -> contientRepository -> findBy(["commandeNumCommande" => $commande]);
            return $this -> view($meubles, Response::HTTP_OK);
        }
        return $this -> view(['message' => 'Erreur'], Response::HTTP_NOT_FOUND);
    }
    /**
     * @RequestParam(name="etat_commande")
     */
    public function postClientCommandeAction(Client $clientCommander, ParamFetcher $paramFetcher)
    {
        $client = $clientCommander;
        $etatcommande = $this -> getDoctrine() -> getRepository(EtatCommande::class) ->find($paramFetcher -> get("etat_commande"));
        $commande = new Commande();
        $commande -> setEtatCommande($etatcommande);
        $commande -> setClientNumClient($client);
        $this -> entityManager -> persist($commande);
        $this -> entityManager -> flush();
        return $this -> view($commande, Response::HTTP_CREATED) ;
    }
    /**
     * @RequestParam(name="meuble")
     * @RequestParam(name="nombre_commande")
     */
    public function postClientCommandeMeublesAction(Client $clientCommander,Commande $commande, ParamFetcher $paramFetcher)
    {
        if($clientCommander == $commande -> getClientNumClient())
        {
            $nombrecommande = $paramFetcher -> get("nombre_commande");
            $numserie = $paramFetcher -> get("meuble");
            $meuble = $this -> getDoctrine() -> getRepository(Meuble::class) -> find($numserie);
            $contient = new Contient();
            $contient -> setMeubleNumSerie($meuble)
                -> setCommandeNumCommande($commande)
                -> setNombreCommande($nombrecommande)
            ;
            $this -> entityManager -> persist($contient);
            $this -> entityManager -> flush();
            return $this -> view($commande, Response::HTTP_CREATED);
        }else{
            return $this -> view(['message' => 'Erreur'], Response::HTTP_NOT_ACCEPTABLE);
        }
        
    }



    /**
     * @RequestParam(name="meuble")
     * @RequestParam(name="nombre_commande")
     */
    public function putClientCommandeMeubleAction(Client $clientCommander,Commande $commande,Contient $contient, ParamFetcher $paramFetcher)
    {
        if($clientCommander == $commande -> getClientNumClient())
        {
            $nombrecommande = $paramFetcher -> get("nombre_commande");
            $numserie = $paramFetcher -> get("meuble");
            $meuble = $this -> getDoctrine() -> getRepository(Meuble::class) -> find($numserie);
            $contient -> setMeubleNumSerie($meuble)
                -> setNombreCommande($nombrecommande)
            ;
            $this -> entityManager -> flush();
            return $this -> view($commande, Response::HTTP_OK);
        }
        
    }



    public function deleteClientCommandeMeublesAction(Client $clientCommander,Commande $commande, Contient $contient)
    {   
        if($clientCommander == $commande -> getClientNumClient()){
            $this -> entityManager -> remove($contient);
            $this -> entityManager -> flush();
            return $this -> view($contient, Response::HTTP_OK);
        }
        return $this -> view(['message' => 'Erreur'], Response::HTTP_NOT_FOUND);
    }

    public function deleteClientCommandeAction(Client $clientCommander, Commande $commande)
    {
        if($clientCommander == $commande -> getClientNumClient()){
            $this -> entityManager -> remove($commande);
            $this -> entityManager -> flush();
            return $this -> view($commande, Response::HTTP_OK);
        }
        return $this -> view(['message' => 'Erreur'], Response::HTTP_NOT_FOUND);
    }
    // FIN CRUD Commandes    
}