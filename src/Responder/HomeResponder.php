<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 23:43
 */

namespace App\Responder;


use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class HomeResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * HomeResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param $storyList
     * @param $total
     * @param $form
     * @return Response
     */
    public function __invoke($storyList,$total,FormView $form)
    {
        return new Response(
            $this->twig->render('home.html.twig',[
                'stories' => $storyList,
                'total'   => $total,
                'filter'  => $form
            ])
        );
    }
}