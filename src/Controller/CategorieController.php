<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Categorie;

class CategorieController extends AbstractController
{
    #[Route('/Lister_categorie', name: 'lister_categorie')]
    public function index(EntityManagerInterface $entityManager): Response
    {    $listCategorie = $entityManager->getRepository('App\Entity\Categorie')->findAll();  
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'listCategorie' => $listCategorie,
        ]);
    }

    #[Route('/Ajout_categorie', name: 'ajout_categorie')]
    public function Ajout(EntityManagerInterface $entityManager): Response
    {  
        return $this->render('categorie/Ajouter.html.twig', [
            'controller_name' => 'CategorieController',

        ]);
    }

    #[Route('/modif_categorie', name: 'modifier_categorie')]
    public function Modifier(): Response
    {
        return $this->render('categorie/Modifier.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    #[Route('/categorieAjout', name: 'app_ajoutCategorie')]
    public function ajouter(EntityManagerInterface $entityManager): Response
    {
        extract($_POST);
        $categorie = new Categorie();
        $categorie -> setNom($name);
        $entityManager->persist($categorie);
        $entityManager->flush();
        $listCategorie = $entityManager->getRepository('App\Entity\Categorie')->findAll();
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'listCategorie' => $listCategorie,
        ]);
    }
}





