<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class LoginController extends AbstractController
{
    #[Route('/', name: 'app_login')]
    public function index(): Response
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    #[Route('/loginAuth', name: 'app_loginAuth')]
    public function login(EntityManagerInterface $entityManager): Response
    {
        extract($_POST);
        $listUser = $entityManager->getRepository('App\Entity\User')->findAll();
        $trouve = false;
        foreach ($listUser as $value) {
        if($value->getEmail() == $email && $value->getPassword() == md5($password) ) {
            if($value->getRole() -> getId() == 1){
                $trouve = true;
                return $this->render('user/Admin.html.twig', [
                    'controller_name' => 'UserController',
                    'listUser' => $listUser,
                    'user' => $value,
                ]);
            }else if($value->getRole() -> getId() == 2) {
                $trouve = true;
                return $this->render('user/User.html.twig', [
                    'controller_name' => 'UserController',
                    'user' => $value,
                    'listUser' => $listUser,
                ]);
            }
        }
        }
        if($trouve == false) {
                return $this->render('login/index.html.twig', [
                    'controller_name' => 'LoginController',
                ]);
        }
    }
}
