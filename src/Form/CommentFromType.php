<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentFromType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comment', TextType::class,[
                'attr'=>[
                    'class'=>'form-control mb-3',
                    'placeholder'=>'Write your comment here...'
                ],
                'label'=>false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please Write something',
                    ]),
                ],
               
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
           // 'data_class' => Comment::class,
        ]);
    }
}
