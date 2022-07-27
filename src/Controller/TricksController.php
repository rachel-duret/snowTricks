<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Video;
use App\Form\TrickFormType;
use App\Repository\TrickRepository;
use DateTime;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;


class TricksController extends AbstractController
{
    private $em;
    private $trickRepository;

    public function __construct(TrickRepository $trickRepository, EntityManagerInterface $em)
    {
        $this->trickRepository =$trickRepository;
        $this->em = $em;
    }

    #[Route('/create', name:'create')]
    public function create(Request $request): Response
    {
        $trick = new Trick();
        $category = new Category();
        $image = new Image();
        $video = new Video();
        $user = new User();
        $form = $this->createForm(TrickFormType::class, [$trick, $category]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            //set Category
            $name=$form->get('name')->getData();
            $category->setName($name);
            $this->em->persist($category);

           /*  $trick->setCategory($category);
            $trick = $form->getData(); */
            $imagePath = $form->get('image')->getData();
  
            if($imagePath){
                $newFileName = uniqid().'.'.$imagePath->guessExtension();

                try{
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads', $newFileName
                    );
                    
                }catch (FileException $e){
                    return new Response($e->getMessage());
                }
                $image->setImagePath('/uploads/'.$newFileName);
                
            $this->em->persist($image);

            
            }
            // set User

            //set Video
            $video->setVideoPath('https://www.youtube.com/watch?v=BwVDEsLx_Ig');    
            $this->em->persist($video);

            //set Trick
            $userid=2;
            $title=$form->get('title')->getData();
            $date = new DateTimeImmutable();
            $description=$form->get('description')->getData();
            $trick->setTitle($title);
            $trick->setDescription($description);
            $trick->setCreatAt($date);
            $trick->setUser($this->getUser($userid));
           
        
           
    
            $this->em->persist($trick);
            $this->em->flush();
            
        }
        return $this->render('tricks/create.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    
    #[Route('/tricks', name: 'app_tricks')]
    public function index(TrickRepository $trickRepository): Response
    {
        $tricks = $trickRepository->findAll();
       
        return $this->render('tricks/index.html.twig', [
            'tricks' => $tricks,
        ]);
    }
}
