<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 12/01/2018
 * Time: 00:10
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddLegalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,[
                'constraints' => [new NotBlank(),
                                  new Length(['min' => 3,
                                              'max' => 30
                    ])
                ],
            ])
            ->add('article',TextareaType::class,[
                  'constraints' => [new NotBlank()
                  ],
                  'required'    => false,
                  'label'       => 'Article'
            ])
            ->add('status',ChoiceType::class,[
                'constraints' => [new NotBlank()
                ],
                'choices' => ['Save and publish'  => 'published',
                              'Work in progress'  => 'wip',
                ],
                'placeholder' => 'Choose a status',
            ]);
    }
}