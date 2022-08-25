<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Video;
use App\Form\ImageFormType;
use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{
    public function __construct(private TrickRepository $trickRepository, private ImageRepository $imageRepository, private EntityManagerInterface $em)
    {
    }
    #[Route('/upload_file/{title}', methods: ['GET', 'POST'], name: 'app_upload_file')]
    public function index(Request $request, $title): Response
    {
        $trick = $this->trickRepository->findOneBy(['title'=>$title]);
        $form = $this->createForm(ImageFormType::class);
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
                //persist image
                $image = new Image();
                $image->setImagePath('/uploads/' . $newFileName);
                $image->setTrick($trick);
                $this->em->persist($image);


                //persist video
                $videoPath = $form->get('video')->getData();
                if ($videoPath) {
                    $video = new Video();
                    $video->setVideoPath($videoPath);
                    $video->setTrick($trick);
                    $this->em->persist($video);
                }

                $this->em->flush();

                return $this->redirectToRoute('app_trick', array('title' => $trick->getTitle()));
            }
        }
        return $this->render('file/index.html.twig', [
            'fileForm' => $form->createView()
        ]);
    }

    #[Route("/delete_image/{id}", methods: ['GET', 'DELETE'], name: "app_delete_image")]
    public function deleteFile($id): Response
    {
        $image = $this->imageRepository->find($id);
        $user = $this->getUser();
        $trick = $image->getTrick();
      

        if ($user == $trick->getUser()) {

            $fileName = $image->getImagePath();
            $fileSystem = new Filesystem();
            $fileSystem->remove( $this->getParameter('kernel.project_dir') . '/public/uploads',
            $fileName);
            $this->em->remove($image);
            $this->em->flush();
            return $this->redirectToRoute('app_trick', array('title' => $trick->getTitle()));
        }
        $this->addFlash('danger', 'You do not have the right to delete this picture.');
        return $this->redirectToRoute('app_trick', array('title' => $trick->getTitle()));
    }
}
