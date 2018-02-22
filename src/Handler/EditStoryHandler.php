<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/01/2018
 * Time: 16:21
 */

namespace App\Handler;

use App\Handler\Inter\EditStoryHandlerInterface;
use Symfony\Component\Form\FormInterface;

class EditStoryHandler implements EditStoryHandlerInterface
{

    /**
     * @param FormInterface $form
     * @param $story
     * @return bool
     */
    public function handle(FormInterface $form, $story): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {

            $story->setTitle(
                $form->get('title')->getData()
            );
            $story->setAbstract(
                $form->get('abstract')->getData()
            );
            $story->setPlot(
                $form->get('plot')->getData()
            );

            return true;
        }

        return false;
    }
}
