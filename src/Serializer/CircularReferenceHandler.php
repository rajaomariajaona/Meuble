<?php
namespace App\Serializer;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Meuble;
use Symfony\Component\Routing\RouterInterface;

class CircularReferenceHandler{
    private $router;
    public function __construct(RouterInterface $router)
    {
        $this -> router = $router;
    }
    public function __invoke($object)
    {
        switch($object){
            case $object instanceof Meuble:
                    return $this -> router -> generate('get_meuble',['meuble' => $object -> getNumSerie()]);
            break;
            case $object instanceof Client:
                    return $this -> router -> generate('get_client',['client' => $object -> getNumClient()]);
            break;
            case $object instanceof Commande:
                    return $this -> router -> generate('get_commande',['commande' => $object -> getNumCommande()]);
            break;
        }
        echo("Missing at circular handler");
    }
}