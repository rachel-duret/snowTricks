<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('video', UrlType::class,[
                'required'=>false,
                'attr'=>[
                    'class'=>'form-control mb-3',
                    'placeholder'=>'Enter your video URL '
                ]
            ])
            ->add('image', FileType::class,[
                'attr'=>[
                    'class'=>'form-control mb-3'
                ],
                'constraints'=>[
                    new File([
                        'maxSize'=>'1024k',
                        'mimeTypes'=>[
                            'image/png',
                            'image/jpg',
                            'image/jpeg'
                        ]
                    ])
                ]
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
