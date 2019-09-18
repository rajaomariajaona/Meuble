<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Contient;
use App\Entity\Meuble;
use App\Repository\CommandeRepository;
use App\Repository\ContientRepository;
use DateTime;
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
        return $this -> view($data, Response::HTTP_OK) ;
    }
    public function getCommandeAction(Commande $commande)
    {
        $data = $this ->commandeRepository -> findBy(['commandeNumCommande' => $commande ]);
        return $this -> view($data, Response::HTTP_OK) ;
    }

    /**
     * @RequestParam(name="date_commande")
     * @RequestParam(name="num_client")
     */
    public function postCommandeAction(ParamFetcher $paramFetcher)
    {
        $client = $this -> getDoctrine() -> getRepository(Client::class) -> find($paramFetcher -> get('num_client'));
        $commande = new Commande();
        $commande -> setDateCommande(new DateTime($paramFetcher -> get('date_commande')))
        ;
        $commande -> setClientNumClient($client);
        $this -> entityManager -> persist($commande);
        $this -> entityManager -> flush();
        return $this -> view($commande, Response::HTTP_CREATED) ;
    }

        /**
     * @RequestParam(name="date_commande")
     * @RequestParam(name="num_client")
     */
    public function putCommandeAction(Commande $commande,ParamFetcher $paramFetcher)
    {
        $client = $this -> getDoctrine() -> getRepository(Client::class) -> find($paramFetcher -> get('num_client'));
        $commande -> setDateCommande(new DateTime($paramFetcher -> get('date_commande')))
        ;
        $commande -> setClientNumClient($client);
        $this -> entityManager -> persist($commande);
        $this -> entityManager -> flush();
        return $this -> view($commande, Response::HTTP_CREATED) ;
    }

    public function deleteCommandeAction(Commande $commande)
    {
            $this -> entityManager -> remove($commande);
            $this -> entityManager -> flush();
            return $this -> view($commande, Response::HTTP_OK);
    }
    // FIN CRUD Commandes
}