<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 24/10/2017
 * Time: 14:05
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('topic', EntityType::class,[
               'class'        => 'App:Topic',
               'choice_label' => 'type',
               'placeholder'  => 'Choose a topic',
               'required'     => false
           ])
           ->add('patronage', EntityType::class,[
               'class'        => 'App:Patronage',
               'choice_label' => 'organization',
               'placeholder'  => 'Choose a patronage',
               'required'     => false
           ])
           ->add('country', CountryType::class,[
               'label'=>'Filter by country',
               'placeholder'  => 'Choose a country',
               'required'     => false
           ])
           ->add('worldArea', ChoiceType::class,[
               'choices' => [
                   'Africa'        => 1,
                   'Asia'          => 2,
                   'Europe'        => 3,
                   'North America' => 4,
                   'South America' => 5,
                   'Oceania'       => 6
               ],
               'placeholder' => 'Choose a world area',
               'required'     => false
           ]);
    }
}

