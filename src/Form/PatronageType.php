<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 15/10/17
 * Time: 10:51
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\OptionsResolver\OptionsResolver;

class PatronageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('organization',ChoiceType::class,['constraints' => [new NotBlank()],
                'choices' => ['ong'             => 'ong',
                             'company'          => 'company',
                             'town hall'        => 'town hall',
                             'county'           => 'county',
                             'association'      => 'association',
                             'private investor' => 'private investor',
                ],
                'label' => 'project investor'
            ])
            ->add('identity', TextType::class,['label' => 'investor name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data-class'=> 'App\Entity\Patronage']);
    }
}
