<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 12:39
 */

namespace App\Responder;


use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class AdminEditStoryResponder
{
    private $twig;

    /**
     * AdminEditStoryResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param $story
     * @param FormView $form
     * @return Response
     */
    public function __invoke($story, FormView $form)
    {
       return new Response(
           $this->twig->render(['admin\adminEditStory.html.twig',
               'story' => $story,
               'form'  => $form
           ])
       );
    }
}