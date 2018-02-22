<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/01/2018
 * Time: 15:47
 */

namespace App\Responder;


use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class BrowseResponder
{
    private $twig;

    /**
     * BrowseResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param $stories
     * @param $page
     * @param $totalPage
     * @param FormView $form
     * @param $title
     * @param $country
     * @param $topic
     * @param $patronage
     * @param $worldArea
     * @return Response
     */
    public function __invoke(
        $stories,
        $page,
        $totalPage,
        FormView $form,
        $title,
        $country = null,
        $topic = null,
        $patronage = null,
        $worldArea = null
    )
    {
        return new Response(
            $this->twig->render('pagination.html.twig',[
                'stories'    => $stories,
                'pageNumber' => $page,
                'totalPage'  => $totalPage,
                'filter'     => $form,
                'title'      => $title,
                'country'    => $country,
                'topic'      => $topic,
                'patronage'  => $patronage,
                'worldArea'  => $worldArea
            ])
        );
    }


}
