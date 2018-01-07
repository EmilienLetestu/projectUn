<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/01/2018
 * Time: 20:28
 */

namespace App\Handler\Inter;


use App\Entity\Story;
use Symfony\Component\Form\FormInterface;

interface AddStoryHandlerInterface
{
    public function handle(FormInterface $form, Story $story) : bool;
}