<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/01/2018
 * Time: 16:58
 */

namespace App\Handler;


use App\Handler\Inter\AdministratorCredentialHandlerInterface;
use Symfony\Component\Form\FormInterface;

class AdministratorCredentialHandler implements AdministratorCredentialHandlerInterface
{
    /**
     * @param FormInterface $form
     * @param $user
     * @return bool
     */
    public function handle(FormInterface $form, $user): bool
    {
        if($form->isSubmitted() && $form->isValid())
        {
            $form->get('email')->getData() !== null ?
                $user->setEmail($form->get('email')->getData()) :
                null
            ;
            $form->get('name')->getData() !== null ?
                $user->setName($form->get('name')->getData()) :
                null
            ;
            $form->get('surname')->getData() !== null ?
                $user->setSurname($form->get('surname')->getData()) :
                null
            ;

            $user->setPswd($form->get('pswd')->getData());

            return true;
        }
        return false;
    }

}
