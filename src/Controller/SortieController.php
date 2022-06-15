<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Sortie;

class SortieController extends AbstractController
{
    #[Route('/Lister_sortie', name: 'lister_sortie')]
    public function index(EntityManagerInterface $entityManager): Response
    {   $listSortie = $entityManager->getRepository('App\Entity\Sortie')->findAll();
        return $this->render('sortie/index.html.twig', [
            'controller_name' => 'SortieController',
            'listSortie' => $listSortie,

        ]);
    }

    #[Route('/Ajout_sortie', name: 'ajout_sortie')]
    public function Ajouter(EntityManagerInterface $entityManager): Response
    {   $produit = $entityManager->getRepository('App\Entity\Produit')->findAll();
        return $this->render('sortie/Ajouter.html.twig', [
            'controller_name' => 'SortieController',
            'listProduit' => $produit,
        ]);
    }

    #[Route('/sortieAjout', name: 'app_ajoutSortie')]
    public function ajout(EntityManagerInterface $entityManager): Response
    {
        extract($_POST);
        if(isset($product)) {
            $sortie = new Sortie();
            $sortie->setQuantite($quantite);
            $sortie->setPrix($prix);
            $sortie->setDate($date);
            $produit = $entityManager->getRepository('App\Entity\Produit')->find($product);
            $sortie->setProduit($produit);
            $entityManager->persist($sortie);
            $entityManager->flush();
            //produit
            $produit->setStock($produit->getStock() - $quantite);
            $entityManager->persist($produit);
            $entityManager->flush();
            $listSortie = $entityManager->getRepository('App\Entity\Sortie')->findAll();
            return $this->render('sortie/index.html.twig', [
                'controller_name' => 'SortieController',
                'listSortie' => $listSortie,
            ]);
        }else {
            return $this -> Ajouter($entityManager);
        }
    }
}
