<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/01/2018
 * Time: 19:32
 */

namespace App\Handler\Inter;


use App\Entity\User;
use Symfony\Component\Form\FormInterface;

interface RegisterHandlerInterface
{
    /**
     * @param FormInterface $form
     * @param User $user
     * @return mixed
     */
    public function handle(FormInterface $form, User $user);
}