<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 11:06
 */

namespace App\Responder;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class AdminByStoryResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * AdminByStoryResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param $story
     * @return Response
     */
    public function __invoke($story)
    {
       return new Response(
           $this->twig->render('admin\adminStoryData.html.twig',[
           'story' => $story
           ])
       );
    }


}