<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 11:41
 */

namespace App\Responder\Admin;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class AdminStoryResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * AdminStoryResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param array $storyList
     * @return Response
     */
    public function __invoke(array $storyList)
    {
        return new Response($this->twig->render('admin\adminStory.html.twig',[
            'storyList' => $storyList[0],
            'title'     => $storyList[1]
            ])
        );
    }
}