<?php

namespace App\Controller;

use App\Form\ActivateAccountFormType;
use App\Form\ForgottenPasswordFormType;
use App\Form\ResetPasswordFormType;
use App\Repository\UserRepository;
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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em, private UserRepository $userRepository)
    {
    }
    /* ************************ Login page*********************************** */
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {

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

    /* ************************ Activate account page*********************************** */
    #[Route('/activate_account/{token}',  name: 'app_activate_account')]
    public function activateAccount($token, Request $request): Response
    {
        $user = $this->userRepository->findOneBy(['token' => $token]);

        if ($user) {
            $form = $this->createForm(ActivateAccountFormType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user->setToken(null);
                $user->setIsVerified(true);

                $this->em->persist($user);
                $this->em->flush($user);
                $this->addFlash('success', 'Your account already activated .');

                return $this->redirectToRoute('app_login');
            }
            return $this->render('security/activate_account.html.twig', [
                'activateForm' => $form->createView()
            ]);
        }
        $this->addFlash('danger', 'Page do not exist .');
        return $this->redirectToRoute('app_home');
    }

    /* ************************ Reactivate accountpage*********************************** */
    #[Route('/reactivate_account', name: 'app_reactivate_account')]
    public function reactivateAccount(
        Request $request,
        TokenGeneratorInterface $tokenGeneratorInterface,
        MailerInterface $mailer
    ): Response {
        $form = $this->createForm(ForgottenPasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $this->userRepository->findOneBy(['email' => $email]);

            // Generate a new token
            if ($user) {
                if ($user->isIsVerified()) {
                    $this->addFlash('danger', 'Your account already activated Please login!');
                    return $this->redirectToRoute('app_login');
                }
                $token = $user->getToken();
                //send a link to reset password
                $url = $this->generateUrl('app_activate_account', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
                // create data for email
                $context = compact('url', 'user');
                $mail = (new Email())
                    ->from($this->getParameter('app.email'))
                    ->to($email)
                    ->subject('Ractivate Account')
                    ->html("<p>$url</p>");
                $mailer->send($mail);
                $this->addFlash('success', 'Email already send. please check your email !');
                return $this->redirectToRoute('app_login');
            }
            //$this->addFlash('danger', 'User do not exist .');
            $this->addFlash('danger', 'User does not exist !');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reactivate_account.html.twig', [
            'reactivateAccountForm' => $form->createView()
        ]);
    }

    /* ***********************Forgotten Password page*************************** */
    #[Route('/forgotten_password', name: 'app_forgotten_password')]
    public function token(
        Request $request,
        TokenGeneratorInterface $tokenGeneratorInterface,
        MailerInterface $mailer
    ): Response {
        $form = $this->createForm(ForgottenPasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $this->userRepository->findOneBy(['email' => $email]);

            // Generate a new token
            if ($user) {
                $token = $tokenGeneratorInterface->generateToken();
                $user->setToken($token);
                $this->em->persist($user);
                $this->em->flush();

                //send a link to reset password
                $url = $this->generateUrl('app_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
                // create data for email
                $context = compact('url', 'user');
                $mail = (new Email())
                    ->from($this->getParameter('app.email'))
                    ->to($email)
                    ->subject('Reset Password')
                    ->html("<p>$url</p>");
                $mailer->send($mail);
                $this->addFlash('success', 'Email already send. please check your email !');
                return $this->redirectToRoute('app_login');
            }
            //$this->addFlash('danger', 'User do not exist .');
            $this->addFlash('danger', 'User does not exist !');
            return $this->redirectToRoute('app_login');
        }

        // Render view
        return $this->render('security/forgotten_password.html.twig', [
            'forgottenPasswordForm' => $form->createView()
        ]);
    }

    /* ***********************Reset Password page*************************** */
    #[Route('/reset_password/{token}', name: 'app_reset_password')]
    public function resetPassword(
        string $token,
        Request $request,
        UserPasswordHasherInterface $passwordHasher

    ): Response {
        // check we have this token in the database
        $user = $this->userRepository->findOneBy(['token' => $token]);
        if ($user) {
            $form = $this->createForm(ResetPasswordFormType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                //delete token in database

                $user->setToken(null);
                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );

                $this->em->persist($user);
                $this->em->flush($user);

                $this->addFlash('success', 'You password reset successful !');
                return $this->redirectToRoute('app_home');
            }


            return $this->render('security/reset_password.html.twig', [
                'resetPasswordForm' => $form->createView()
            ]);
        }


        $this->addFlash('danger', 'Token Invalide');
        return $this->redirectToRoute('app_login');
    }
}
