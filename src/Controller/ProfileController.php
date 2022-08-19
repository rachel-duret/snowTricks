<?php

namespace App\Controller;

use App\Form\ProfileUpdateFormType;
use App\Repository\TrickRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserRepository $userRepository,
        private TrickRepository $trickRepository
    ) {
    }
    #[Route('/profile/{id}/{username}', methods: ['GET'], name: 'app_profile')]
    public function index($id): Response
    {
        $user = $this->userRepository->find($id);
        if ($user) {
            $tricks = $this->trickRepository->findby(['user' => $id]);


            return $this->render('profile/index.html.twig', [
                'controller_name' => 'ProfileController',
                'user' => $user,
                'tricks' => $tricks
            ]);
        }
        $this->addFlash('danger', 'Page not find');
        return $this->redirectToRoute('app_home');
    }

    #[Route('/profile/update/{id}/{username}', methods: ['GET', 'POST'], name: 'app_profile_update')]
    public function profileUpdate($id, Request $request): Response
    {
        $user = $this->userRepository->find($id);
        if ($user) {

            $form = $this->createForm(ProfileUpdateFormType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $imagePath = $form->get('image')->getData();
                if ($imagePath) {
                    $newFileName = uniqid() . '.' . $imagePath->guessExtension();
                    try {
                        $imagePath->move(
                            $this->getParameter('kernel.project_dir') . '/public/uploads',
                            $newFileName
                        );
                    } catch (FileException $e) {
                        return new Response($e->getMessage());
                    }

                    $user->setImage('/uploads/' . $newFileName);
                    $this->em->persist($user);
                    $this->em->flush($user);

                    $this->addFlash('success', 'Your profile already update .');
                    return $this->redirectToRoute('app_profile', array('id' => $user->getId(), 'username' => $user->getUsername()));
                }
            }



            return $this->render('profile/update.html.twig', [
                'form' => $form->createView(),
                'user' => $user
            ]);
        }
    }
}
