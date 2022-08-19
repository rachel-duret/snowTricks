<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class RegistrationController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, TokenGeneratorInterface $tokenGeneratorInterface, UserPasswordHasherInterface $userPasswordHasher, MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            //Generate token
            $token = $tokenGeneratorInterface->generateToken();
            $user->setToken($token);
            $user->setIsVerified(false);

            $this->em->persist($user);
            $this->em->flush($user);
            // Generate url to activate new account
            $url = $this->generateUrl('app_activate_account', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

            //send an email
            $userEmail = $form->get('email')->getData();
            $email = (new Email())
                ->from('no-reply@snowtricks.com')
                ->to($userEmail)
                ->subject('Activate Account')
                ->html("<p>$url</p>");
            $mailer->send($email);

            $this->addFlash('success', 'Account create successful, Please check your email to activate.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
