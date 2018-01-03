<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 16:06
 */

namespace App\Responder;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class AdminTopicResponder
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke($list, $form)
    {
        return new Response(
            $this->twig->render('admin\adminTopic.html.twig',[
                'topicList' => $list,
                'form'      => $form
            ])
        );
    }
}