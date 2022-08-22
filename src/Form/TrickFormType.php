<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class TrickFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title',TextType::class, [
            'attr'=> array(
                'class'=>'form-control mb-3',
                'placeholder'=>'Trick title..'
            ),
            'label'=>false
        ])
        ->add('name', TextType::class, [
            'attr'=> array(
                'class'=>'form-control mb-3',
                'placeholder'=>'Category'
            ),
            'label'=>false
        ])

       
        ->add('description', TextareaType::class, [
            'attr'=> array(
                'class'=>'form-control mb-3',
                'placeholder'=>''
            ),
            'label'=>false
        ])
        ->add('videoEmbed', TextType::class, [
            'attr'=> array(
                'class'=>'form-control mb-3',
                'placeholder'=>'Your video embed code'
                
            ),
            'label'=>false,
            'required'=>false,
        ])
        ->add('video', FileType::class, [
            'attr'=> array(
                'class'=>'form-control mb-3',
                
            ),
            'label'=>'Video, Accept MP4 file, max size 250M ',
            'required'=>false,
            'constraints'=>[
                new File([
                    'maxSize'=>'5120k',
                    'mimeTypes'=>[
                        'video/mp4',
                    ]
                ])
            ]
        ])
        ->add('image', FileType::class, [
            'attr'=> array(
                'class'=>'form-control mb-3',
                
            ),
            'label'=>'Image, Accept PMG JPG JPEG file, max size 5120k',
            'constraints'=>[
                new File([
                    'maxSize'=>'5120k',
                    'mimeTypes'=>[
                        'image/png',
                        'image/jpg',
                        'image/jpeg',
                    ]
                ])
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
