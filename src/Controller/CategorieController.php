<?php

namespace App\Controller;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\RequestParam;

class CategorieController extends AbstractFOSRestController
{
    private $entityManager;
    private $categorieRepository;
    public function __construct(EntityManagerInterface $entityManager, CategorieRepository $categorieRepository)
    {
        $this -> entityManager = $entityManager;
        $this -> categorieRepository = $categorieRepository;
    }
    public function getCategoriesAction()
    {
        $data = $this -> categorieRepository -> findAll();
        return $this -> view($data, Response::HTTP_OK);
    }

    public function getCategorieAction(Categorie $categorie)
    {
        $data = $this -> categorieRepository -> find($categorie);
        if($data){

            return $this -> view($data, Response::HTTP_OK);
        }else{
            return $this -> view(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @RequestParam(name="categorie")
     */
    public function postCategoriesAction(ParamFetcher $paramFetcher)
    {
        $nom = $paramFetcher -> get("categorie");
        $categorie = new Categorie();
        $categorie ->setCategorie($nom);
        $this -> entityManager -> persist($categorie);
        $this -> entityManager -> flush();
        return $this -> view($categorie, Response::HTTP_CREATED);
    }

    public function deleteCategorieAction(Categorie $categorieDelete)
    {
        $categorie = $this -> categorieRepository -> find($categorieDelete);
        $this -> entityManager -> remove($categorie);
        $this -> entityManager -> flush();
        return $this -> view($categorie, Response::HTTP_OK);
    }
    /**
     * @RequestParam(name="categorie")
     */
    public function putCategoriesAction(ParamFetcher $paramFetcher, Categorie $categorieModif)
    {
        $nom = $paramFetcher -> get("categorie");
        $categorie = $this -> categorieRepository -> find($categorieModif);
        $categorie -> setCategorie($nom);
        $this -> entityManager -> persist($categorie);
        $this -> entityManager -> flush();
        return $this -> view($categorie, Response::HTTP_OK);
    }
}
