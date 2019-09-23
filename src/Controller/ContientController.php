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
    }

    /**
     * @RequestParam(name="numserie")
     * @RequestParam(name="nombrecommande")
     */
    public function putCommandeContientAction(Commande $commandeA, Meuble $meubleA, ParamFetcher $paramFetcher)
    {
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
        }
    }

    

    public function deleteCommandeContientsAction(Commande $commandeA, Meuble $meubleA)
    {   
        $contient = $this -> contientRepository -> findOneBy(['commandeNumCommande' => $commandeA, 'meubleNumSerie' => $meubleA]);
            $this -> entityManager -> remove($contient);
            $this -> entityManager -> flush();
            return $this -> view($contient, Response::HTTP_OK);
    }

    public function deleteCommandeContientsCancelAction(Commande $commande, Meuble $meuble)
    {   
        $contient = $this -> contientRepository -> findOneBy(['commandeNumCommande' => $commande, 'meubleNumSerie' => $meuble]);

        $nombreCommandee = $contient -> getNombreCommande();
        $nombreStock = $meuble -> getQuantiteStock();
        $oldCommande = $nombreCommandee + $nombreStock;
        $meuble -> setQuantiteStock($oldCommande);
        $this -> entityManager -> remove($contient);
        $this -> entityManager -> flush();
        return $this -> view($contient, Response::HTTP_OK);
    }

    // FIN CRUD Contients
}