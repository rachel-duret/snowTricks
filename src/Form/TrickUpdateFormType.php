<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
        ->add('category', EntityType::class, [
           'class'=>Category::class,
           'choice_label'=>'name',
           'attr'=>[
            'class'=>'form-control'
           ]
           
        ])

       
        ->add('description', TextareaType::class, [
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
           //'data_class' => Trick::class,
        ]);
    }
}
