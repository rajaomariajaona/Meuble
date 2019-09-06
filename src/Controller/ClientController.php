<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Province;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\RequestParam;

class ClientController extends AbstractFOSRestController
{
    
    public function __construct(ClientRepository $clientRepository, EntityManagerInterface $em)
    {
        $this-> clientRepository = $clientRepository;
        $this -> entityManager = $em;
    }
    private $entityManager;

    // CRUD Clients

    public function getClientsAction()
    {
        $data = $this -> clientRepository -> findAll();
        return $data ;
    }
    public function getClientAction(Client $client)
    {
        $data = $client;
        return $this -> view($data, Response::HTTP_OK) ;
    }
    /**
     * @RequestParam(name="nom")
     * @RequestParam(name="prenom")
     * @RequestParam(name="adresse")
     * @RequestParam(name="email")
     * @RequestParam(name="tel")
     * @RequestParam(name="cp")
     * @RequestParam(name="province")
     * 
     */
    public function postClientsAction(ParamFetcher $paramFetcher)
    {
        $nom = $paramFetcher -> get("nom");
        $prenom = $paramFetcher -> get("prenom");
        $adresse = $paramFetcher -> get("adresse");
        $cp = $paramFetcher -> get("cp");
        $email = $paramFetcher -> get("email");
        $tel = $paramFetcher -> get("tel");
        $province = $this->getDoctrine()->getRepository(Province::class) ->find($paramFetcher -> get("province"));

        $client = new Client();
        $client -> setNomClient($nom)
        ->setPrenomClient($prenom)
        ->setAdresseClient($adresse)
        ->setCpClient($cp)
        ->setEmailClient($email)
        ->setTelClient($tel)
        ->setProvinceClient($province);
        $this -> entityManager -> persist($client);
        $this -> entityManager -> flush();
        return $this -> view($client, Response::HTTP_CREATED) ;
    }
        /**
     * @RequestParam(name="nom")
     * @RequestParam(name="prenom")
     * @RequestParam(name="adresse")
     * @RequestParam(name="email")
     * @RequestParam(name="tel")
     * @RequestParam(name="cp")
     * @RequestParam(name="province")
     * 
     */
    public function putClientsAction(ParamFetcher $paramFetcher, Client $clientModif)
    {
        $client = $this -> clientRepository -> find($clientModif);
        $nom = $paramFetcher -> get("nom");
        $prenom = $paramFetcher -> get("prenom");
        $adresse = $paramFetcher -> get("adresse");
        $cp = $paramFetcher -> get("cp");
        $email = $paramFetcher -> get("email");
        $tel = $paramFetcher -> get("tel");
        $province = $this->getDoctrine()->getRepository(Province::class) ->find($paramFetcher -> get("province"));

        $client -> setNomClient($nom)
        ->setPrenomClient($prenom)
        ->setAdresseClient($adresse)
        ->setCpClient($cp)
        ->setEmailClient($email)
        ->setTelClient($tel)
        ->setProvinceClient($province);
        $this -> entityManager -> persist($client);
        $this -> entityManager -> flush();
        return $this -> view($client, Response::HTTP_OK) ;
    }
    public function deleteClientsAction(Client $clientDelete)
    {
        $client = $this -> clientRepository -> find($clientDelete);
        $this -> entityManager -> remove($client);
        $this -> entityManager -> flush();
        return $this -> view($client, Response::HTTP_OK) ;
    }

    // FIN CRUD Clients

    
}
