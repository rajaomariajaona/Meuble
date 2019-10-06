<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
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

    public function getCommandeContientsAction(Commande $commande)
    {
        $data = $this -> contientRepository -> findBy(['commandeNumCommande' => $commande]);
        return $this -> view($data, Response::HTTP_OK) ;
    }

    public function getCommandeContientAction(Commande $commande, Meuble $meuble)
    {
        $contient = $this -> contientRepository -> findOneBy(['commandeNumCommande' => $commande, 'meubleNumSerie' => $meuble]);
        return $this -> view($contient, Response::HTTP_OK) ;
    }


    /**
     * @RequestParam(name="numserie")
     * @RequestParam(name="nombrecommande")
     */
    public function postCommandeContientAction(Commande $commande, ParamFetcher $paramFetcher)
    {
        if(!($commande -> getLivree())){
            $contient = new Contient();
        $meuble = $this -> getDoctrine() -> getRepository(Meuble::class) -> find($paramFetcher -> get("numserie"));

        $nombreCommandee = $paramFetcher -> get("nombrecommande");
        $nombreStock = $meuble -> getQuantiteStock();

        if($nombreStock >= $nombreCommandee){
            $nombreStock = $meuble -> getQuantiteStock();
        
            $contient -> setMeubleNumSerie($meuble) 
                 -> setCommandeNumCommande($commande)
                 -> setNombreCommande($paramFetcher -> get("nombrecommande"))
            ;
            $newStock = $nombreStock - $nombreCommandee;
            $meuble -> setQuantiteStock($newStock);
            
            $this -> entityManager -> persist($contient);
            $this -> entityManager -> persist($meuble);
            $this -> entityManager -> flush();
            return $this -> view($contient, Response::HTTP_CREATED) ;
        }else{
            return $this -> view(['messages' => 'Erreur de commande'], Response::HTTP_NOT_ACCEPTABLE) ;
        }
        }else{
            return $this -> view(['messages' => 'Erreur ajout commande livree'], Response::HTTP_NOT_ACCEPTABLE) ;
        }
        
    }

    /**
     * @RequestParam(name="numserie")
     * @RequestParam(name="nombrecommande")
     */
    public function putCommandeContientAction(Commande $commandeA, Meuble $meubleA, ParamFetcher $paramFetcher)
    {
        if(!($commandeA -> getLivree())){

            $contient = $this -> contientRepository -> findOneBy(['commandeNumCommande' => $commandeA, 'meubleNumSerie' => $meubleA]);
    
            $meuble = $this -> getDoctrine() -> getRepository(Meuble::class) -> find($paramFetcher -> get("numserie"));
    
            $nombreStock = $meuble -> getQuantiteStock();
            $nombreCommandee = $paramFetcher -> get("nombrecommande");
    
            if($nombreCommandee >= $nombreStock){
                $newStock = $nombreStock - $nombreCommandee;
                $contient -> setMeubleNumSerie($meuble)
                -> setNombreCommande()
                ;
                $meuble -> setQuantiteStock($newStock);
    
                $this -> entityManager -> persist($contient);
                $this -> entityManager -> persist($meuble);
                $this -> entityManager -> flush();
                return $this -> view($contient, Response::HTTP_OK);
            }else{
                return $this -> view(['messages' => 'Erreur de commande'], Response::HTTP_NOT_ACCEPTABLE) ;
            }
        }else{
            return $this -> view(['messages' => 'Erreur ajout commande livree'], Response::HTTP_NOT_ACCEPTABLE) ;
        }
    }

    public function deleteCommandeContientsAction(Commande $commande, Meuble $meuble)
    {   
        if(!($commande -> getLivree())){
            $contient = $this -> contientRepository -> findOneBy(['commandeNumCommande' => $commande, 'meubleNumSerie' => $meuble]);

            $nombreCommandee = $contient -> getNombreCommande();
            $nombreStock = $meuble -> getQuantiteStock();
            $oldCommande = $nombreCommandee + $nombreStock;
            $meuble -> setQuantiteStock($oldCommande);
            $this -> entityManager -> remove($contient);
            $this -> entityManager -> flush();
            return $this -> view($contient, Response::HTTP_OK);
        }else{
            return $this -> view(['messages' => 'Erreur suppression commande livree'], Response::HTTP_NOT_ACCEPTABLE) ;
        }
    }
    // FIN CRUD Contients

    //CRUD facture

    public function getFactureAction(Commande $commande)
    {
        $manager = $this->getDoctrine()->getManager();
        $query = "SELECT nom_Client as nomClient, prenom_Client as prenomClient, tel_client as telClient, client.adresse_client as adresseClient ,CONCAT(client.province_client, ' ', client.cp_client) as provinceClient, commande.num_commande as numCommande, commande.date_commande as dateCommande, contient.meuble_num_serie as numSerie, meuble.nom_meuble as nomMeuble, contient.nombre_commande as quantiteCommande, meuble.prix as prixUnitaire, (meuble.prix * contient.nombre_commande) as prixTotal, meuble.categorie from client inner join commande on client.num_client = commande.client_num_client inner join contient on commande.num_commande = contient.commande_num_commande inner join meuble on contient.meuble_num_serie = meuble.num_serie WHERE commande.num_commande = :numCommande";
        $statement = $manager->getConnection()->prepare($query);
        $statement->execute(['numCommande' => $commande -> getNumCommande()]);
        $facture = $statement->fetchAll();
        return $this -> view($facture, Response::HTTP_OK) ;
    }


    //fin crud facture

}