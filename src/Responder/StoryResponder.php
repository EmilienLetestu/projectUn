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
     * @param array $topic
     * @param array $country
     * @param array $year
     * @param array $patronage
     * @param $resource
     * @param $next
     * @param $previous
     * @return Response
     */
    public function __invoke(
        $story,
        array $topic,
        array $country,
        array $year,
        array $patronage,
        $resource,
        $next,
        $previous
    )
    {
        return new Response(
            $this->twig->render('story.html.twig',[
                'story'         => $story,
                'sameTopic'     => $topic,
                'sameCountry'   => $country,
                'sameYear'      => $year,
                'samePatronage' => $patronage,
                'extResources'  => $resource,
                'next'          => $next,
                'previous'      => $previous
            ])
        );
    }
}