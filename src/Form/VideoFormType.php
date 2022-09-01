<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class VideoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
