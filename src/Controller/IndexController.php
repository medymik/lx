<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(UserInterface $user = null)
    {
        if($user)
        {
            return $this->redirectToRoute('products');
            
        }else{
            return $this->redirectToRoute('app_login');
        }
    }
}
