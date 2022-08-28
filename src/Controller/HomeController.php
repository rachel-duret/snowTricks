<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    public function __construct(private TrickRepository $trickRepository)
    {
    }

    #[Route('/', methods: ['GET'], name: 'app_home')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $data = $this->trickRepository->findBy([], ['createdAt' => 'DESC']);

        $tricks = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            10
        );

        

        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,

        ]);
    }

}
