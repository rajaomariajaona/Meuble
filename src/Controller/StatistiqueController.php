<?php

namespace App\Controller;

use App\Entity\Contient;
use App\Entity\Meuble;
use App\Repository\MeubleRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\RequestParam;

class StatistiqueController extends AbstractFOSRestController
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }
    private $entityManager;

    /**
     * @QueryParam(name="jour", default=null, nullable=true)
     * @QueryParam(name="mois", default=null, nullable=true)
     * @QueryParam(name="annee", default=null, nullable=true)
     */
    public function getMeubleplusvendueAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->getDoctrine()->getManager();
        switch (true) {
            case null !== ($paramFetcher->get("annee")):
                $query = "SELECT nom_meuble as nomMeuble, SUM(`nombre_commande`) as somme FROM contient inner join meuble on meuble_num_serie = num_serie inner JOIN commande on commande_num_commande = num_commande where YEAR(date_commande) = YEAR('" . $paramFetcher->get("annee") . "') GROUP by `meuble_num_serie`order by SUM(`nombre_commande`) DESC";
                break;
            case null !== ($paramFetcher->get("jour")):
                $query = "SELECT nom_meuble as nomMeuble, SUM(`nombre_commande`) as somme FROM contient inner join meuble on meuble_num_serie = num_serie inner JOIN commande on commande_num_commande = num_commande where DATE(date_commande) = '" . $paramFetcher->get("jour") . "' GROUP by `meuble_num_serie`order by SUM(`nombre_commande`) DESC";
                break;
            case null !== ($paramFetcher->get("mois")):
                $query = "SELECT nom_meuble as nomMeuble, SUM(`nombre_commande`) as somme FROM contient inner join meuble on meuble_num_serie = num_serie inner JOIN commande on commande_num_commande = num_commande where MONTH(date_commande) = MONTH('" . $paramFetcher->get("mois") . "') and YEAR(date_commande) = YEAR('" . $paramFetcher->get("mois") . "') GROUP by `meuble_num_serie`order by SUM(`nombre_commande`) DESC";
                break;
            default:
                $query = "SELECT nom_meuble as nomMeuble, SUM(`nombre_commande`) as somme FROM contient inner join meuble on meuble_num_serie = num_serie inner JOIN commande on commande_num_commande = num_commande where DATE(date_commande) = DATE(CURRENT_DATE()) GROUP by `meuble_num_serie`order by SUM(`nombre_commande`) DESC";
                break;
        }

        $statement = $manager->getConnection()->prepare($query);
        $statement->execute();
        $meuble = $statement->fetchAll();
        return $this->view($meuble, Response::HTTP_OK);
    }

    /**
     * @QueryParam(name="jour", default=null, nullable=true)
     * @QueryParam(name="mois", default=null, nullable=true)
     * @QueryParam(name="annee", default=null, nullable=true)
     */
    public function getCategorieplusvendueAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->getDoctrine()->getManager();
        switch (true) {
            case null !== ($paramFetcher->get("annee")):
                $query = "SELECT categorie, SUM(nombre_commande) as nombre from contient inner join meuble on num_serie = meuble_num_serie inner join commande on commande_num_commande = num_commande where YEAR(date_commande) = YEAR('" . $paramFetcher->get("annee") . "')  GROUP BY categorie ORDER BY nombre DESC";
                break;
            case null !== ($paramFetcher->get("jour")):
                $query = "SELECT categorie, SUM(nombre_commande) as nombre from contient inner join meuble on num_serie = meuble_num_serie inner join commande on commande_num_commande = num_commande where DATE(date_commande) = '" . $paramFetcher->get("jour") . "' GROUP BY categorie ORDER BY nombre DESC";
                break;
            case null !== ($paramFetcher->get("mois")):
                $query = "SELECT categorie, SUM(nombre_commande) as nombre from contient inner join meuble on num_serie = meuble_num_serie inner join commande on commande_num_commande = num_commande where MONTH(date_commande) = MONTH('" . $paramFetcher->get("mois") . "') and YEAR(date_commande) = YEAR('" . $paramFetcher->get("mois") . "') GROUP BY categorie ORDER BY nombre DESC";
                break;
            default:
                $query = " SELECT categorie, SUM(nombre_commande) as nombre from contient inner join meuble on num_serie = meuble_num_serie inner join commande on commande_num_commande = num_commande where DATE(date_commande) = DATE(CURRENT_DATE()) GROUP BY categorie ORDER BY nombre DESC";
                break;
        }

        $statement = $manager->getConnection()->prepare($query);
        $statement->execute();
        $meuble = $statement->fetchAll();
        return $this->view($meuble, Response::HTTP_OK);
    }

    /**
     * @QueryParam(name="jour", default=null, nullable=true)
     * @QueryParam(name="mois", default=null, nullable=true)
     * @QueryParam(name="annee", default=null, nullable=true)
     */
    public function getClientplusacheteurAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->getDoctrine()->getManager();
        switch (true) {
            case null !== ($paramFetcher->get("annee")):
                $query = "SELECT CONCAT(nom_client, ' ', prenom_client) as nomClient, SUM(prix * nombre_commande) as prixTotal from client inner join commande on num_client = client_num_client inner join contient on commande_num_commande = num_commande inner join meuble on num_serie = meuble_num_serie where YEAR(date_commande) = YEAR('" . $paramFetcher->get("annee") . "') GROUP by num_client order by prixtotal desc";
                break;
            case null !== ($paramFetcher->get("jour")):
                $query = "SELECT CONCAT(nom_client, ' ', prenom_client) as nomClient, SUM(prix * nombre_commande) as prixTotal from client inner join commande on num_client = client_num_client inner join contient on commande_num_commande = num_commande inner join meuble on num_serie = meuble_num_serie where DATE(date_commande) = '" . $paramFetcher->get("jour") . "'  GROUP by num_client order by prixtotal desc";
                break;
            case null !== ($paramFetcher->get("mois")):
                $query = "SELECT CONCAT(nom_client, ' ', prenom_client) as nomClient, SUM(prix * nombre_commande) as prixTotal from client inner join commande on num_client = client_num_client inner join contient on commande_num_commande = num_commande inner join meuble on num_serie = meuble_num_serie where MONTH(date_commande) = MONTH('" . $paramFetcher->get("mois") . "') and YEAR(date_commande) = YEAR('" . $paramFetcher->get("mois") . "') GROUP by num_client order by prixtotal desc";
                break;
            default:
                $query = "SELECT CONCAT(nom_client, ' ', prenom_client) as nomClient, SUM(prix * nombre_commande) as prixTotal from client inner join commande on num_client = client_num_client inner join contient on commande_num_commande = num_commande inner join meuble on num_serie = meuble_num_serie where DATE(date_commande) = DATE(CURRENT_DATE()) GROUP by num_client order by prixtotal desc";

                break;
        }

        $statement = $manager->getConnection()->prepare($query);
        $statement->execute();
        $meuble = $statement->fetchAll();
        return $this->view($meuble, Response::HTTP_OK);
    }

    /**
     * @QueryParam(name="mois", default=null, nullable=true)
     */
    public function getStatventeAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->getDoctrine()->getManager();

        $query = "SELECT date_commande as t, SUM(prix * nombre_commande) as y from commande inner join contient on commande_num_commande = num_commande inner join meuble on num_serie = meuble_num_serie where MONTH(date_commande) = MONTH('" . $paramFetcher->get('mois') . "') GROUP BY date_commande";

        $statement = $manager->getConnection()->prepare($query);
        $statement->execute();
        $meuble = $statement->fetchAll();
        return $this->view($meuble, Response::HTTP_OK);
    }
    /**
     * @QueryParam(name="mois", default=null, nullable=true)
     */
    public function getStatmeubleAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->getDoctrine()->getManager();
        $query = "SELECT CONCAT( categorie, ' : ',  nom_meuble) as x, SUM(nombre_commande) as y from commande inner join contient on commande_num_commande = num_commande join meuble on num_serie = meuble_num_serie where MONTH(date_commande) = MONTH('" . $paramFetcher->get('mois') . "') GROUP BY num_serie";

        $statement = $manager->getConnection()->prepare($query);
        $statement->execute();
        $meuble = $statement->fetchAll();
        return $this->view($meuble, Response::HTTP_OK);
    }

    /**
     * @QueryParam(name="mois", default=null, nullable=true)
     */
    public function getStatcategorieAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->getDoctrine()->getManager();
        $query = "SELECT categorie.categorie as x, SUM(nombre_commande) as y from contient inner join meuble on num_serie = meuble_num_serie right join categorie on categorie.categorie = meuble.categorie inner join commande on commande_num_commande = num_commande where MONTH(date_commande) = MONTH('" . $paramFetcher->get('mois') . "') GROUP BY categorie.categorie";
        $statement = $manager->getConnection()->prepare($query);
        $statement->execute();
        $meuble = $statement->fetchAll();
        return $this->view($meuble, Response::HTTP_OK);
    }
}
