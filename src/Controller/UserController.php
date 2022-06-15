<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class UserController extends AbstractController
{
    #[Route('/Lister_user', name: 'lister_user')]
    public function index(EntityManagerInterface $entityManager): Response
    {   $listUser = $entityManager->getRepository('App\Entity\User')->findAll();
         
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'listUser' => $listUser,
        ]);
    }

    #[Route('/Ajout_user', name: 'ajout_user')]
    public function Ajout(EntityManagerInterface $entityManager): Response
    {   $listRole = $entityManager->getRepository('App\Entity\Role')->findAll();
        return $this->render('user/Ajouter.html.twig', [
            'controller_name' => 'UserController',
            'listRole' => $listRole,
        ]);
    }

    #[Route('/modif_user', name: 'modifier_user')]
    public function Modifier(): Response
    {
        return $this->render('user/Modifier.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/Admin_user', name: 'admin_user')]
    public function Admin(): Response
    {
        return $this->render('user/Admin.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/User_user', name: 'user_user')]
    public function User(): Response
    {
        return $this->render('user/User.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/userAjout', name: 'app_ajoutUser')]
    public function ajouter(EntityManagerInterface $entityManager): Response
    {
        extract($_POST);
        $user = new User();
        $user -> setNom($nom);
        $user -> setPrenom($prenom);
        $user -> setPassword(md5($password));
        $user -> setEmail($email);
        $roles = $entityManager->getRepository('App\Entity\Role')->find($role);
        $user -> setRole($roles);
        $trouve = false;
        $listUser = $entityManager->getRepository('App\Entity\User')->findAll();
        foreach ($listUser as $value) {
            if($value -> getEmail() == $email) {
                $trouve = true;
                $listRole = $entityManager->getRepository('App\Entity\Role')->findAll();
                return $this->render('user/add.html.twig', [
                    'controller_name' => 'UserController',
                    'listRole' => $listRole,
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'password' => $password,
                    'email' => $email,
                    'error' => 'Cet email existe  !',
                ]);
            }
        }
        if(!$trouve) {
            $entityManager->persist($user);
            $entityManager->flush();
            $listUser = $entityManager->getRepository('App\Entity\User')->findAll();
            return $this->render('user/index.html.twig', [
                'controller_name' => 'UserController',
                'listUser' => $listUser,
            ]);
        }
    }
}
