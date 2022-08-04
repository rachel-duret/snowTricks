<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Video;
use App\Form\ImageFormType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{
    #[Route('/upload_file/{id}', name: 'app_upload_file')]
    public function index(Request $request, $id, TrickRepository $trickRepository, EntityManagerInterface $em): Response
    {
        $trick=$trickRepository->find($id);
        $form= $this->createForm(ImageFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

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
                //persist image
                $image = new Image();
                $image->setImagePath('/uploads/'.$newFileName);
                $image->setTrick($trick);
                $em->persist($image);


                //persist video
                $videoPath = $form->get('video')->getData();
                if ($videoPath) {
                    $video = new Video();
                    $video->setVideoPath($videoPath);
                    $video->setTrick($trick);
                    $em->persist($video);
                }
               

                $em->flush();
                
                return $this->redirectToRoute('app_trick', array('id'=>$trick->getId()));
               
            
            }
           
        }
        return $this->render('file/index.html.twig', [
            'fileForm' => $form->createView()
        ]);
    }
}
