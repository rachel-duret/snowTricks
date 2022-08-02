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

    #[Route('/create', methods:['GET','POST'], name:'app_create')]
    public function create(Request $request): Response
    {
        $trick = new Trick();
        $category = new Category();
        $form = $this->createForm(TrickFormType::class, [$trick, $category]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            //set Category
            $name=$form->get('name')->getData();
            $category->setName($name);  
        
            //upload image
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
                $trick->setImage('/uploads/'.$newFileName);
            
            }
            //set Trick
            $title=$form->get('title')->getData();
            $description=$form->get('description')->getData();
            $trick->setTitle($title);
            $trick->setDescription($description);
            $trick->setCreatAt(new DateTimeImmutable());
            $trick->setUser($this->getUser());
    
            //relate trick to the category
            $trick->setCategory($category);
           
            $this->em->persist($category);    
            $this->em->persist($trick);
            $this->em->flush();

            return $this->redirectToRoute('app_tricks');
            
        }
        return $this->render('tricks/create.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    
    // Single Trick 
    #[Route('/tricks/{id}', methods: ['GET', 'POST'], name: 'app_trick')]
    public function trick($id, Request $request):Response
    {
      $trick =$this->trickRepository->find($id);
      $category = $trick->getCategory();
      $user= $trick->getUser();

      // show comments,
         $comments = $this->commentRepository->findBy(['trick'=>$trick],['createAt'=>'DESC'],10,0); 
      // Create comment
        $user = $this->getUser();
        $comment= new Comment();
        $form = $this->createForm(CommentFromType::class,$comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $comment->setComment($form->get('comment')->getData());
            $comment->setCreateAt(new DateTimeImmutable());
            $comment->setTrick($trick);
            $comment->setUser($user);

           $this->em->persist($comment);
           $this->em->flush($comment);
           
           return $this->redirectToRoute('app_trick', array('id'=>$trick->getId()));
           
        }


    
      return $this->render('tricks/trick.html.twig', [
        'trick'=>$trick,
        'category'=>$category,
        'user'=>$user,
        'commentForm'=>$form->createView(),
        'comments'=>$comments
      
      ]);
     
    }



    // Update
    #[Route('/tricks/update/{id}',methods:['GET', 'POST'], name: 'app_update')]
    public function update($id, Request $request):Response
    {
      $trick =$this->trickRepository->find($id);
      $category = $this->categoryRepository->find($trick->getId());
      $form = $this->createForm(TrickUpdateFormType::class, [$trick,$category]);
      $form->handleRequest($request);
      $imagePath = $form->get('image')->getData();
      

      if($form->isSubmitted() && $form->isValid()){
        if($imagePath) {
            if($trick->getImage() !==null){

                $newFileName = uniqid().'.'.$imagePath->guessExtension();
                try{
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads', $newFileName
                    );
                    
                }catch (FileException $e){
                    return new Response($e->getMessage());
                }
                $trick->setImage('/uploads/'.$newFileName);
                $this->em->flush();

                return $this->redirectToRoute('app_tricks');
                
            }

        }
            $trick->setTitle($form->get('title')->getData());
            $trick->setDescription($form->get('description')->getData());
            $trick->setUpdateAt(new DateTimeImmutable());
            $category->setName($form->get('name')->getData());
            $trick->setCategory($category);

            $this->em->flush();
            return $this->redirectToRoute('app_tricks');

        
      }
     
      return $this->render('tricks/update.html.twig', [
        'trick'=>$trick,
        'form'=>$form->createView()
      
      ]);
     
    }

    // Delete 
    #[Route('/tricks/delete/{id}',methods:['GET', 'DELETE'], name: 'app_delete')]
    public function delete($id): Response
    {
        $trick= $this->trickRepository->find($id);
        $this->em->remove($trick);
        $this->em->flush();
        return $this->redirectToRoute('app_tricks');
                
    }

}
