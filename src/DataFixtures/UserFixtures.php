<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {
        
    }
    public function load(ObjectManager $manager): void
    {
        //0
       $user = new User();
       $user->setUsername('chuncheung');
       $user->setEmail('chuncheung.ku@gmail.com');
       $user->setRoles(['ROLE_ADMIN']);
       $user->setPassword(
        $this->passwordEncoder->hashPassword($user, 'password')
       );
       $user->setImage('https://unsplash.com/s/photos/user');
       $user->setToken(NULL);
       $user->setIsVerified(true);
       $manager->persist($user);

       //1
       $user1 = new User();
       $user1->setUsername('lara');
       $user1->setEmail('lara@gmail.com');
       $user1->setRoles(['ROLE_USER']);
       $user1->setPassword(
        $this->passwordEncoder->hashPassword($user1, 'password')
       );
       $user1->setImage('https://static.vecteezy.com/ti/vecteur-libre/t2/1993889-belle-femme-latine-avatar-icone-personnage-gratuit-vectoriel.jpg');
       $user1->setToken(NULL);
       $user1->setIsVerified(true);
       $manager->persist($user1);

       //2
       $user2 = new User();
       $user2->setUsername('rachel');
       $user2->setEmail('rachel@gmail.com');
       $user2->setRoles(['ROLE_USER']);
       $user2->setPassword(
        $this->passwordEncoder->hashPassword($user2, 'password')
       );
       $user2->setImage('https://expertphotography.b-cdn.net/wp-content/uploads/2018/10/cool-profile-pictures-retouching-1.jpg');
       $user2->setToken(NULL);
       $user2->setIsVerified(true);
       $manager->persist($user2);

       //3
       $user3 = new User();
       $user3->setUsername('florent');
       $user3->setEmail('florent@gmail.com');
       $user3->setRoles(['ROLE_USER']);
       $user3->setPassword(
        $this->passwordEncoder->hashPassword($user3, 'password')
       );
       $user3->setImage('https://images.unsplash.com/photo-1633332755192-727a05c4013d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8dXNlcnxlbnwwfHwwfHw%3D&w=1000&q=80');
       $user3->setToken(NULL);
       $user3->setIsVerified(true);
       $manager->persist($user3);

       //4
       $user4 = new User();
       $user4->setUsername('gucci');
       $user4->setEmail('gucci@gmail.com');
       $user4->setRoles(['ROLE_USER']);
       $user4->setPassword(
        $this->passwordEncoder->hashPassword($user4, 'password')
       );
       $user4->setImage('https://st4.depositphotos.com/5989284/23844/i/600/depositphotos_238442852-stock-photo-closeup-image-funny-comic-man.jpg');
       $user4->setToken(NULL);
       $user4->setIsVerified(true);
       $manager->persist($user4);

       //5
       $user5 = new User();
       $user5->setUsername('mia');
       $user5->setEmail('mia@gmail.com');
       $user5->setRoles(['ROLE_USER']);
       $user5->setPassword(
        $this->passwordEncoder->hashPassword($user5, 'password')
       );
       $user5->setImage('https://images.unsplash.com/photo-1584670747417-594a9412fba5?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1yZWxhdGVkfDE0fHx8ZW58MHx8fHw%3D&w=1000&q=80');
       $user5->setToken(NULL);
       $user5->setIsVerified(true);
       $manager->persist($user5);

       //6
       $user6 = new User();
       $user6->setUsername('youcat');
       $user6->setEmail('youcat@gmail.com');
       $user6->setRoles(['ROLE_USER']);
       $user6->setPassword(
        $this->passwordEncoder->hashPassword($user6, 'password')
       );
       $user6->setImage('https://images.unsplash.com/photo-1578910985276-6cd1a7bc6dd4?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80');
       $user6->setToken(NULL);
       $user6->setIsVerified(true);
       $manager->persist($user6);

       //7
       $user7 = new User();
       $user7->setUsername('barbie');
       $user7->setEmail('barbie@gmail.com');
       $user7->setRoles(['ROLE_USER']);
       $user7->setPassword(
        $this->passwordEncoder->hashPassword($user7, 'password')
       );
       $user7->setImage('https://images.unsplash.com/photo-1615473967657-9dc21773daa3?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1yZWxhdGVkfDE1fHx8ZW58MHx8fHw%3D&w=1000&q=80');
       $user7->setToken(NULL);
       $user7->setIsVerified(true);
       $manager->persist($user7);

       //8
       $user8 = new User();
       $user8->setUsername('ivan');
       $user8->setEmail('ivan@gmail.com');
       $user8->setRoles(['ROLE_USER']);
       $user8->setPassword(
        $this->passwordEncoder->hashPassword($user8, 'password')
       );
       $user8->setImage('https://wac-cdn.atlassian.com/fr/dam/jcr:ba03a215-2f45-40f5-8540-b2015223c918/Max-R_Headshot%20(1).jpg?cdnVersion=488');
       $user8->setToken(NULL);
       $user8->setIsVerified(true);
       $manager->persist($user8);

       //9
       $user9 = new User();
       $user9->setUsername('leon');
       $user9->setEmail('leon@gmail.com');
       $user9->setRoles(['ROLE_USER']);
       $user9->setPassword(
        $this->passwordEncoder->hashPassword($user9, 'password')
       );
       $user4->setImage('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxLDEajEW8QIw_X_Zt5S-1rxj0-lhuljenolf6zjfThRco-WTZIlp_QU-BIFFBhjhp9uM&usqp=CAU');
       $user9->setToken(NULL);
       $user9->setIsVerified(true);
       $manager->persist($user9);


        $manager->flush();

        $this->addReference('user_0', $user);
        $this->addReference('user_1', $user1);
        $this->addReference('user_2', $user2);
        $this->addReference('user_3', $user3);
        $this->addReference('user_4', $user4);
        $this->addReference('user_5', $user5);
        $this->addReference('user_6', $user6);
        $this->addReference('user_7', $user7);
        $this->addReference('user_8', $user8);
        $this->addReference('user_9', $user9);

    }
}
