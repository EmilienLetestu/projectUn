<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/01/2018
 * Time: 16:58
 */

namespace App\Handler\Inter;


use Symfony\Component\Form\FormInterface;

Interface AdministratorCredentialHandlerInterface
{
    /**
     * @param FormInterface $form
     * @param $user
     * @return bool
     */
    public function handle(FormInterface $form, $user):bool;
}