<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TrickUpdateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title',TextType::class, [
            'attr'=> array(
                'class'=>'form-control text-capitalize my-2',
               
            ),
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a title',
                ]),
               
            ],
            
        ])
        ->add('category', EntityType::class, [
           'class'=>Category::class,
           'choice_label'=>'name',
           'attr'=>[
            'class'=>'form-control text-capitalize my-2'
           ],
           'constraints' => [
            new NotBlank([
                'message' => 'Please enter a category',
            ]),
           
        ],
           
        ])

       
        ->add('description', TextareaType::class, [
            'attr'=> array(
                'class'=>'form-control text-capitalize my-2',
               
            ),
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a description of trick',
                ]),
               
            ],
            
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
