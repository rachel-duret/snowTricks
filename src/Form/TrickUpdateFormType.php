<?php

namespace App\Form;

use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickUpdateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title',TextType::class, [
            'attr'=> array(
                'class'=>'form-control',
               
            ),
            'label'=>false
        ])
        ->add('name', TextType::class, [
            'attr'=> array(
                'class'=>'form-control',
                
            ),
            'label'=>false
        ])

       
        ->add('description', TextareaType::class, [
            'attr'=> array(
                'class'=>'form-control',
               
            ),
            'label'=>false
        ])
        ->add('image', FileType::class, [
            'required'=>false,
            'mapped'=>false,
            'attr'=> array(
                'class'=>'form-control',
               
                
            ),
            'label'=>false
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
           
        ]);
    }
}
