<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/01/2018
 * Time: 08:27
 */

namespace App\Responder;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class StoryResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * StoryResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param $story
     * @param array $related
     * @param $next
     * @param $previous
     * @return Response
     */
    public function __invoke(
        $story,
        array $related,
        $next,
        $previous
    )
    {
        return new Response(
            $this->twig->render('story.html.twig',[
                'story'         => $story,
                'related'       => $related,
                'next'          => $next,
                'previous'      => $previous
            ])
        );
    }
}