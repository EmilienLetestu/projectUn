<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/01/2018
 * Time: 16:18
 */

namespace App\Handler\Inter;

use Symfony\Component\Form\FormInterface;

interface EditStoryHandlerInterface
{
    /**
     * @param FormInterface $form
     * @param $story
     * @return bool
     */
    public function handle(FormInterface $form, $story): bool;
}