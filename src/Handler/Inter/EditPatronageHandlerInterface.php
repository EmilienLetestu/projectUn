<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/01/2018
 * Time: 15:04
 */
namespace App\Handler\Inter;

use App\Entity\Patronage;
use Symfony\Component\Form\FormInterface;


interface EditPatronageHandlerInterface
{
    public function handle(FormInterface $form, Patronage $patronage): bool;
}