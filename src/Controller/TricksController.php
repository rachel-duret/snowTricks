<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{
    #[Route('/tricks', name: 'app_tricks')]
    public function index(TrickRepository $trickRepository): Response
    {
        $tricks = $trickRepository->findAll();
       
        return $this->render('tricks/index.html.twig', [
            'tricks' => $tricks,
        ]);
    }
}
