<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 11/10/17
 * Time: 15:33
 */
namespace App\Form;

use App\Validators\WordLimit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class StoryType extends AbstractType
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
                'required'    => false,
                'label'       => 'Abstract'
            ])
            ->add('plot', TextareaType::class,[
                'constraints' =>[new NotBlank(),
                                 new WordLimit(['limit'=>200])
                ],
                'required'    => false,
                'label'       => 'Project narrative'
            ])
            ->add('contactEmail', EmailType::class,[
                'constraints' => [new NotBlank(),
                                  new Email(),
                                  new Length(['min' => 3,
                                              'max' => 100
                                ])
                ],
                'label'      => 'Your e-mail address'
            ])
            ->add('contactPlace', TextType::class,[
                'constraints' => [new Length(['min' => 3,
                                              'max' => 100
                                ])
                ],
                'label'    => 'Where to meet you',
                'required' => false
            ])
            ->add('contactPhone', TextType::class,[
                'constraints' => [new Length(['min' => 8,
                                             'max' => 20
                                ])
                ],
                'label'    => 'Your phone number',
                'required' => false
            ])
            ->add('topic', EntityType::class,[
                'constraints'  =>[new NotBlank()
                ],
                'class'        => 'App:Topic',
                'choice_label' => 'type',
                'placeholder' => 'Choose a topic',
            ])
            ->add('worldArea', ChoiceType::class,[
                'constraints' =>[new NotBlank()
                ],
                'choices' => ['Africa'        => 1,
                              'Asia'          => 2,
                              'Europe'        => 3,
                              'North America' => 4,
                              'South America' => 5,
                              'Oceania'       => 6
                ],
                'placeholder' => 'Choose a world area',
                'label' => 'In which part of the world this story is sets'
            ])
            ->add('country', CountryType::class,[
                'placeholder' => 'Choose a country',
                'label'       => 'Is this story related to a specific country',
                'required'    => false
            ])
            ->add('year', ChoiceType::class,[
                'choices'     => array_combine(\range(2015, date('Y')),\range(2015, date('Y'))),
                'label'       => 'This story started in',
                'placeholder' => 'Choose a year',
                'required'    => false
            ])
            ->add('patronage', EntityType::class,[
                'constraints'  =>[new NotBlank()
                ],
                'class'        => 'App:Patronage',
                'choice_label' => 'organization',
                'placeholder'  => 'Choose a patronage'
            ])
            ->add('investor', TextType::class,[
                'constraints' =>[new Length(['min' => 2,
                                             'max' => 100
                               ])
                ],
                'label'      =>'Investor name',
                'required'   => false
            ])
            ->add('urls',CollectionType::class,[
                'entry_type' => UrlType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'mapped'       => false,
                'required'     => false
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults(['data-class'=> 'App\Entity\Story']);
    }
}
