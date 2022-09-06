<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Video;
use App\Form\FileFormType;
use App\Form\ImageFormType;
use App\Form\VideoFormType;
use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileController extends AbstractController
{
    public function __construct(
        private TrickRepository $trickRepository,
        private ImageRepository $imageRepository,
        private VideoRepository $videoRepository,
        private EntityManagerInterface $em,
        private SluggerInterface $slugger
    ) {
    }
    #[Route('/upload_file/{slug}/{id}', methods: ['GET', 'POST'], name: 'app_upload_file')]
    public function index(Request $request, $id): Response
    {
        $trick = $this->trickRepository->find($id);
        $form = $this->createForm(FileFormType::class);
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
                $videoEmbedCode = $form->get('videoEmbed')->getData();
                $video = new Video();
                if ($videoPath) {
                    $newVideoFileName = uniqid() . '.' . $videoPath->guessExtension();
                    try {
                        $videoPath->move(
                            $this->getParameter('kernel.project_dir') . '/public/uploads/',
                            $newVideoFileName
                        );
                    } catch (FileException $e) {
                        return new Response($e->getMessage());
                    }
                    $video->setVideoPath('/uploads/' . $newVideoFileName);
                }
                if ($videoEmbedCode) {
                    $video->setVideoEmbedCode($videoEmbedCode);
                }
                $video->setTrick($trick);
                $this->em->persist($video);

                $this->em->flush();

                return $this->redirectToRoute('app_trick', array('slug' => $this->slugger->slug($trick->getTitle()), 'id' => $id));
            }
        }
        return $this->render('file/index.html.twig', [
            'fileForm' => $form->createView()
        ]);
    }

    //update image
    #[Route("/update_image/{id}",  name: "app_update_image")]
    public function updateImageFile($id, Request $request): Response
    {
        $image = $this->imageRepository->find($id);
        $user = $this->getUser();
        $trick = $image->getTrick();
        $form = $this->createForm(ImageFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newImagePath = $form->get('image')->getData();
            if ($user == $trick->getUser()) {
                $fileName = $image->getImagePath();
                if ($fileName) {
                    $fileSystem = new Filesystem();
                    $fileSystem->remove($this->getParameter('kernel.project_dir') . '/public' .
                        $fileName);
                }

                // New image path
                if ($newImagePath) {
                    $newFileName = uniqid() . '.' . $newImagePath->guessExtension();
                    try {
                        $newImagePath->move(
                            $this->getParameter('kernel.project_dir') . '/public/uploads/',
                            $newFileName
                        );
                    } catch (FileException $e) {
                        return new Response($e->getMessage());
                    }
                    $image->setImagePath('/uploads/' . $newFileName);
                }

                $this->em->persist($image);
                $this->em->flush();
                return $this->redirectToRoute('app_trick', array('slug' => $this->slugger->slug($trick->getTitle()), 'id' => $trick->getId()));
            }
            $this->addFlash('danger', 'You do not have the right to update this picture.');

            return $this->redirectToRoute('app_trick', array('slug' => $this->slugger->slug($trick->getTitle()), 'id' => $trick->getId()));
        }



        return $this->render('file/update_image.html.twig', [
            'imageForm' => $form->createView(),
        ]);
    }


    // Delet one image 
    #[Route("/delete_image/{id}", methods: ['GET', 'DELETE'], name: "app_delete_image")]
    public function deleteImageFile($id): Response
    {
        $image = $this->imageRepository->find($id);
        $user = $this->getUser();
        $trick = $image->getTrick();


        if ($user == $trick->getUser()) {

            $fileName = $image->getImagePath();
            $fileSystem = new Filesystem();
            $fileSystem->remove($this->getParameter('kernel.project_dir') . '/public' .
                $fileName);
            $this->em->remove($image);
            if ($fileName === $trick->getMainPicture());{
                $trick->setMainPicture(null);
            }
            $this->em->flush();
            return $this->redirectToRoute('app_trick', array('slug' => $this->slugger->slug($trick->getTitle()), 'id' => $trick->getId()));
        }
        $this->addFlash('danger', 'You do not have the right to delete this picture.');
        return $this->redirectToRoute('app_trick', array('slug' => $this->slugger->slug($trick->getTitle()), 'id' => $trick->getId()));
    }


    //update video
    #[Route("/update_video/{id}",  name: "app_update_video")]
    public function updateVideoFile($id, Request $request): Response
    {
        $video = $this->videoRepository->find($id);
        $user = $this->getUser();
        $trick = $video->getTrick();
        if ($user == $trick->getUser()) {
            $form = $this->createForm(VideoFormType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $newVideoPath = $form->get('video')->getData();
                $newVideoEmbedCode = $form->get('videoEmbed')->getData();
                // Check video fields is all null or not 
                if ($newVideoEmbedCode === null && $newVideoPath === null) {
                    $this->addFlash('danger', 'At least one of field is required.');
                    return $this->redirectToRoute('app_update_video', array('id' => $id));
                }


                $videoPath = $video->getVideoPath();
                $videoEmbedCode = $video->getVideoEmbedCode();
                if ($videoPath) {
                    $fileSystem = new Filesystem();
                    $fileSystem->remove($this->getParameter('kernel.project_dir') . '/public' .
                        $videoPath);
                    $video->setVideoPath(null);
                }
                if ($videoEmbedCode) {
                    $video->setVideoEmbedCode(null);
                }

                // New image path
                if ($newVideoPath) {
                    $newFileName = uniqid() . '.' . $newVideoPath->guessExtension();
                    try {
                        $newVideoPath->move(
                            $this->getParameter('kernel.project_dir') . '/public/uploads/',
                            $newFileName
                        );
                    } catch (FileException $e) {
                        return new Response($e->getMessage());
                    }
                    $video->setVideoPath('/uploads/' . $newFileName);
                }
                if ($newVideoEmbedCode) {
                    $video->setVideoEmbedCode($newVideoEmbedCode);
                }

                $this->em->persist($video);
                $this->em->flush();

                $this->addFlash('success', 'Video already updated .');
                return $this->redirectToRoute('app_trick', array('slug' => $this->slugger->slug($trick->getTitle()), 'id' => $trick->getId()));
            }

            return $this->render('file/update_video.html.twig', [
                'videoForm' => $form->createView(),
            ]);
        }

        $this->addFlash('danger', 'You do not have the right to update this video.');
        return $this->redirectToRoute('app_trick', array('slug' => $this->slugger->slug($trick->getTitle()), 'id' => $trick->getId()));
    }

    // Delete video
    #[Route("/delete_video/{id}", methods: ['GET', 'DELETE'], name: "app_delete_video")]
    public function deleteVideoFile($id): Response
    {
        $video = $this->videoRepository->find($id);
        $user = $this->getUser();
        $trick = $video->getTrick();


        if ($user == $trick->getUser()) {
            $fileName = $video->getVideoPath();
            $videoEmbedCode = $video->getVideoEmbedCode();
            if ($fileName) {
                $fileSystem = new Filesystem();
                $fileSystem->remove($this->getParameter('kernel.project_dir') . '/public' .
                    $fileName);
                if ($video->getVideoEmbedCode()) {
                    $video->setVideoPath(null);
                }
            }
            if ($videoEmbedCode) {
                if ($video->getVideoPath()) {
                    $video->setVideoEmbedCode(null);
                }
            }
            $this->em->remove($video);
            $this->em->flush();
            return $this->redirectToRoute('app_trick', array('slug' => $this->slugger->slug($trick->getTitle()), 'id' => $trick->getId()));
        }
        $this->addFlash('danger', 'You do not have the right to delete this video');
        return $this->redirectToRoute('app_trick', array('slug' => $this->slugger->slug($trick->getTitle()), 'id' => $trick->getId()));
    }

    // Main picture setting of trick
    #[Route("/trick/main_picture/{id}", methods: ['GET'], name: 'app_trick_main_picture')]
    public function trickMainPicture($id)
    {
        $image = $this->imageRepository->find($id);
        $trick = $image->getTrick();
        $user = $this->getUser();
        if ($user == $trick->getUser()) {
            $mainPicturePath = $image->getImagePath();
            $trick->setMainPicture($mainPicturePath);

            $this->em->flush();
            $this->addFlash('success', 'Main picture changed success');
            return $this->redirectToRoute('app_trick', array('slug' => $this->slugger->slug($trick->getTitle()), 'id' => $trick->getId()));
        }

        $this->addFlash('danger', 'You do not have the right to set this picture');
        return $this->redirectToRoute('app_trick', array('slug' => $this->slugger->slug($trick->getTitle()), 'id' => $trick->getId()));
    }
}
