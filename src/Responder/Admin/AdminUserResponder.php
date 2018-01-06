<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 10:19
 */

namespace App\Responder\Admin;


use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class AdminUserResponder
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * AdminUserResponder constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param array $userList
     * @return Response
     */
    public function __invoke(array $userList)
    {
        return new Response(
            $this->twig->render('admin/adminUser.html.twig',[
                'userList' => $userList
            ])
        );
    }
}