<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Entree;

class EntreeController extends AbstractController
{
    #[Route('/Lister_entree', name: 'lister_entree')]
    public function index(EntityManagerInterface $entityManager): Response
    {    $listEntree = $entityManager->getRepository('App\Entity\Entree')->findAll();
        return $this->render('entree/index.html.twig', [
            'controller_name' => 'EntreeController',
            'listEntree' => $listEntree,
        ]);
    }

    #[Route('/Ajout_entree', name: 'ajout_entree')]
    public function Ajout(EntityManagerInterface $entityManager): Response
    {   $produit = $entityManager->getRepository('App\Entity\Produit')->findAll();
        return $this->render('entree/Ajouter.html.twig', [
            'controller_name' => 'EntreeController',
            'listProduit' => $produit,

        ]);
    }

    #[Route('/entreeAjout', name: 'app_ajoutEntree')]
    public function ajouter(EntityManagerInterface $entityManager): Response
    {
        extract($_POST);
        if(isset($product)) {
            $entree = new Entree();
            $entree->setQuantite($quantite);
            $entree->setPrix($prix);
            $entree->setDate($date);
            $produit = $entityManager->getRepository('App\Entity\Produit')->find($product);
            $entree->setProduit($produit);
            $entityManager->persist($entree);
            $entityManager->flush();
            //produit
            $produit->setStock($quantite + $produit->getStock());
            $entityManager->persist($produit);
            $entityManager->flush();
            $listEntree = $entityManager->getRepository('App\Entity\Entree')->findAll();
            return $this->render('entree/index.html.twig', [
                'controller_name' => 'EntreeController',
                'listEntree' => $listEntree,
            ]);
        }else {
            return $this -> Ajout($entityManager);
        }
    }
}
