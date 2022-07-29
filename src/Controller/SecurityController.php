<?php

namespace App\Controller;

use App\Form\ResetPasswordFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/forgotten_password', name: 'app_forgotten_password')]
    public function token(Request $request, UserRepository $userRepository,
     TokenGeneratorInterface $tokenGeneratorInterface,
     EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ResetPasswordFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $email = $form->get('email')->getData();
            $user = $userRepository->findOneBy(['email'=>$email]);

            // Generate a new token
            if($user){
                $token = $tokenGeneratorInterface->generateToken();
                $user->setResetPassword($token);
                $em->persist($user);
                $em->flush();

                //send a link to reset password
            } 
            //$this->addFlash('danger', 'User do not exist .');
            return $this->redirectToRoute('app_login');
        
        }

        // Render view
        return $this->render('security/forgotten_password.html.twig', [
            'resetPasswordForm'=>$form->createView()
        ]);
    }

  /*   #[Route('/reset_password/{token}', name: 'app_reset_password')]
    public function resetPassword(): Response
    {
        return $this->render('security/reset_password.html.twig');
    } */
}
