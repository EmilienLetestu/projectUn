<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 16:06
 */

namespace App\Responder\Admin;


use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class AdminTopicResponder
{
    private $twig;

    /**
     * AdminTopicResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param $list
     * @param FormView $form
     * @return Response
     */
    public function __invoke($list, FormView $form)
    {
        return new Response(
            $this->twig->render('admin\adminTopic.html.twig',[
                'topicList' => $list,
                'form'      => $form
            ])
        );
    }
}
