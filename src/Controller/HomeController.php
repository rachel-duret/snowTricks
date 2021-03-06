<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', methods:['GET'] ,name: 'app_home')]
    public function index(TrickRepository $trickRepository): Response
    {
        $tricks = $trickRepository->findBy([],['creatAt'=>'DESC'],10,0);
        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
    
        ]);
        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
        ]);
    }
}
