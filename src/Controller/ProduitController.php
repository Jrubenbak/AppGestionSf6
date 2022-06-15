<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Produit;

class ProduitController extends AbstractController
{
    #[Route('/Lister_produit', name: 'lister_produit')]
    public function index(EntityManagerInterface $entityManager): Response
    {   $listProduit = $entityManager->getRepository('App\Entity\Produit')->findAll();
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
            'listProduit' => $listProduit,

        ]);
    }

    #[Route('/Ajout_produit', name: 'ajout_produit')]
    public function Ajout(EntityManagerInterface $entityManager): Response
    {   $Categorie = $entityManager->getRepository('App\Entity\Categorie')->findAll();
        return $this->render('produit/Ajouter.html.twig', [
            'controller_name' => 'ProduitController',
            'listCategorie' => $Categorie,
        ]);
    }

    #[Route('/modif_produit', name: 'modifier_produit')]
    public function Modifier(): Response
    {
        return $this->render('produit/Modifier.html.twig', [
            'controller_name' => 'ProduitController',
        ]);
    }

    #[Route('/produitAjout', name: 'app_ajoutProduit')]
    public function ajouter(EntityManagerInterface $entityManager): Response
    {
        extract($_POST);
        if(isset($categorie)) {
            $produit = new Produit();
            $produit->setLibelle($libelle);
            $produit->setStock($stock);
            $Categorie = $entityManager->getRepository('App\Entity\Categorie')->find($categorie);
            $produit->setCategorie($Categorie);
            $entityManager->persist($produit);
            $entityManager->flush();
            $listProduit = $entityManager->getRepository('App\Entity\Produit')->findAll();
            return $this->render('produit/index.html.twig', [
                'controller_name' => 'ProduitController',
                'listProduit' => $listProduit,
            ]);
        }else {
            return $this -> Ajout($entityManager);
        }
    }
}
