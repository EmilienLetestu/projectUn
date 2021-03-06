<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/01/2018
 * Time: 15:46
 */

namespace App\Handler\Inter;


use App\Entity\Topic;
use Symfony\Component\Form\FormInterface;

Interface EditTopicHandlerInterface
{
    /**
     * @param FormInterface $form
     * @param Topic $topic
     * @return bool
     */
    public function handle(FormInterface $form, Topic $topic) :bool;
}
