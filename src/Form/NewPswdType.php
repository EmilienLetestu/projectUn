<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 17/10/17
 * Time: 10:28
 */

namespace App\Form;

use App\Validators\PswdFormat;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class NewPswdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pswd', PasswordType::class, [
                'constraints' => [new NotBlank(),
                                  new PswdFormat(),
                                  new Type('string'),
                                  new Length(['min' => 6,
                                              'max' => 30,
                                  ])
                ],
                'label' => 'New password'
            ])
            ->add('confirmPswd', PasswordType::class, [
                'constraints' => [new NotBlank(),
                                  new Type('string')
                                 ],
                'required' => true,
                'mapped'   => false,
                'label'    => 'Confirm password'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults(['data-class', 'App\Entity\User']);
    }
}