<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/01/2018
 * Time: 21:12
 */

namespace App\Form;


use App\Validators\PswdFormat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;


class AdministratorCredentialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'constraints'=>[new Type('string'),
                                new Length(['min' => 3,
                                            'max' => 30
                                ])
                ],
                'label' => 'Name',
                'required' => false,
                'mapped'   => false
            ])

            ->add('surname', TextType::class,[
                'constraints'=>[new Type('string'),
                                new Length(['min' => 3,
                                            'max' => 30
                                ])
                ],
                'label' => 'Surname',
                'required' => false,
                'mapped'   => false
            ])

            ->add('email', EmailType::class,[
                'constraints'=>[new Email()],
                'label'    => 'E-mail',
                'required' => false,
                'mapped'   => false
            ])

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
                'label'    => 'Confirm your new password'
            ])
        ;
    }
}
