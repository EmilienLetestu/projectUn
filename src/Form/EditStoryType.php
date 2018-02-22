<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 20/12/2017
 * Time: 23:25
 */

namespace App\Form;


use App\Validators\WordLimit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditStoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[
                'constraints'=>[new NotBlank(),
                    new Length(['min' => 5,
                                'max' => 100,
                    ])
                ],
                'label'      => 'Title'
            ])
            ->add('abstract', TextareaType::class,[
                'constraints' =>[new NotBlank(),
                                 new WordLimit(['limit'=>70])
                ],
                'label'       => 'Abstract'
            ])
            ->add('plot', TextareaType::class,[
                'constraints' =>[new NotBlank(),
                    new WordLimit(['limit'=>200])
                ],
                'label'       => 'Project narrative'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data-class'=> 'App\Entity\Story']);
    }
}
