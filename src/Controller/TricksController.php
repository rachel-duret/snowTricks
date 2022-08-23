<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Video;
use App\Form\CommentFromType;
use App\Form\TrickFormType;
use App\Form\TrickUpdateFormType;
use App\Form\TrickUpdateType;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Repository\VideoRepository;
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

    public function __construct(private TrickRepository $trickRepository, private ImageRepository $imageRepository, private CategoryRepository $categoryRepository, private VideoRepository $videoRepository, private CommentRepository $commentRepository, private EntityManagerInterface $em)
    {
    }

    #[Route('/create', methods: ['GET', 'POST'], name: 'app_create')]
    public function create(Request $request): Response
    {
        $trick = new Trick();
        $video = new Video();
        $newCategory = new Category();
        $form = $this->createForm(TrickFormType::class, [$trick, $newCategory]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // To check trick already exist or not
            $newTrick = $this->trickRepository->findBy(['title' => $form->get('title')->getData()]);
            if (!$newTrick) {

                $video->setVideoEmbedCode($form->get('videoEmbed')->getData());
                //upload video
                $videoPath = $form->get('video')->getData();
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
                $trick->addVideo($video);
                //upload image
                $imagePath = $form->get('image')->getData();

                if ($imagePath) {
                    $newFileName = uniqid() . '.' . $imagePath->guessExtension();
                    try {
                        $imagePath->move(
                            $this->getParameter('kernel.project_dir') . '/public/uploads/',
                            $newFileName
                        );
                    } catch (FileException $e) {
                        return new Response($e->getMessage());
                    }
                    $image = new Image();
                    $image->setImagePath('/uploads/' . $newFileName);
                }
                $trick->addImage($image);
                //set Trick
                $title = $form->get('title')->getData();
                $description = $form->get('description')->getData();
                $trick->setTitle($title);
                $trick->setDescription($description);
                $trick->setCreatAt(new DateTimeImmutable());
                $trick->setUser($this->getUser());

                //set Category          

                $name = $form->get('name')->getData();
                $category = $this->categoryRepository->findOneBy(['name' => $name]);
                if ($category) {
                    $trick->setCategory($category);
                    $this->em->persist($category);
                } else {
                    $newCategory->setName($name);
                    $trick->setCategory($newCategory);
                    $this->em->persist($newCategory);
                }



                $this->em->persist($trick);
                $this->em->persist($image);
                $this->em->persist($video);
                $this->em->flush();

                return $this->redirectToRoute('app_home');
            }

            $this->addFlash('danger', 'Trick alredy exist. Please create another trick !');
        }
        return $this->render('tricks/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    // Single Trick 
    #[Route('/tricks/{title}', methods: ['GET', 'POST'], name: 'app_trick')]
    public function trick($title, Request $request): Response
    {
        $trick = $this->trickRepository->findOneBy(['title'=>$title]);
        $user = $trick->getUser();
      
        // show comments,
        $comments = $this->commentRepository->findBy(['trick' => $trick], ['createAt' => 'DESC'], 10, 0);

        // Create comment
        $user = $this->getUser();

        $comment = new Comment();
        $form = $this->createForm(CommentFromType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setComment($form->get('comment')->getData());
            $comment->setCreateAt(new DateTimeImmutable());
            $comment->setTrick($trick);
            $comment->setUser($user);

            $this->em->persist($comment);
            $this->em->flush($comment);

            return $this->redirectToRoute('app_trick', array('title' => $trick->getTitle()));
        }



        return $this->render('tricks/trick.html.twig', [
            'trick' => $trick,
            'commentForm' => $form->createView(),
            'comments' => $comments

        ]);
    }



    // Update
    #[Route('/tricks/update/{title}', methods: ['GET', 'POST'], name: 'app_update')]
    public function update($title, Request $request): Response
    {
        $trick = $this->trickRepository->findOneBy(['title'=> $title]);
        $form = $this->createForm(TrickUpdateFormType::class, $trick);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $newTrick = $this->trickRepository->findBy(['title' => $form->get('title')->getData()]);
            if (!$newTrick) {
                $trick->setTitle($form->get('title')->getData());
                $trick->setDescription($form->get('description')->getData());
                $trick->setUpdateAt(new DateTimeImmutable());
                $trick->setCategory($form->get('category')->getData());

                $this->em->flush();
                return $this->redirectToRoute('app_trick', array('title' => $trick->getTitle()));
            }
            $this->addFlash('danger', 'Trick alredy exist. Please create another trick !');
        }

        return $this->render('tricks/update.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()

        ]);
    }

    // Delete 
    #[Route('/tricks/delete/{title}', methods: ['GET', 'DELETE'], name: 'app_delete')]
    public function delete($title): Response
    {
        $trick = $this->trickRepository->findOneBy(['title'=>$title]);
        $user = $this->getUser();
        if ($user == $trick->getUser()) {

            $this->em->remove($trick);
            $this->em->flush();
            return $this->redirectToRoute('app_home');
        }
        $this->addFlash('danger', 'You do not have the right to delete this trick');
        return $this->redirectToRoute('app_home');
    }
}
