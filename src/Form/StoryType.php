<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 11/10/17
 * Time: 15:33
 */
namespace App\Form;


use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class StoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,['constraints'=>[new NotBlank()],
                                                       'label' => 'Title'
            ])
            ->add('abstract', CKEditorType::class,['constraints'=>[new NotBlank()],
                                                             'label' => 'Abstract'
            ])
            ->add('plot', CKEditorType::class,['constraints'=>[new NotBlank()],
                                                          'label' => 'Project Narrative'
            ])
            ->add('contactEmail', EmailType::class,['constraints'=>[new NotBlank()],
                                                             'label' => 'Your e-mail address'
            ])
            ->add('contactPlace', TextType::class,['label' => 'Where to meet you'
            ])
            ->add('contactPhone', TextType::class,['label' => 'Your phone number'
            ])
            ->add('topic', EntityType::class, ['constraints' =>[new NotBlank()],
                                                          'class' => 'App:Topic',
                                                          'choice_label' => 'type'
            ])
            ->add('country', CountryType::class,['label'=>'This story set in'
            ])
            ->add('year', TextType::class,['label'  => 'This story started in'])
            ->add('patronage', PatronageType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults(['data-class'=> 'App\Entity\Story']);
    }


}