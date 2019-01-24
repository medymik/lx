<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $req,ObjectManager $manager,UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User;
        $form = $this->createForm(RegistrationFormType::class,$user);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $user->setPassword($encoder->encodePassword($user,$user->getPassword()));
            $user->setRoles(['ROLE_USER']);
            $user->setActive(false);
            $user->setSolde(0);
            $manager->persist($user);
            $manager->flush();
            
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
    }

    

    /**
     * @Route("/confirmation", name="app_confirmation")
     */
    public function confirmation()
    {
        return $this->render('security/confirmation.html.twig');
    }

}
