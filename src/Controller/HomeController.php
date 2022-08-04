<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    public function __construct(private TrickRepository $trickRepository)
    {
        
    }
    
    #[Route('/', methods:['GET'] ,name: 'app_home')]
    public function index(): Response
    {
        $tricks = $this->trickRepository->findBy([],['creatAt'=>'DESC'],1,0);
      
        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
    
        ]);
       
    }

    #[Route("/tricks", methods:['GET'], name:"app_tricks")]
    public function loadMore(){
        $tricks = $this->trickRepository->findBy([],['creatAt'=>'DESC']);
      

        return $this->render('home/tricks.html.twig', [
            'tricks' => $tricks,
        ]);
    }
}
