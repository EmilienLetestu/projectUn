<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 10:36
 */

namespace App\Action\Admin;


use App\Entity\User;
use App\Responder\Admin\AdminByUserResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AdminByUserAction
{

    private $doctrine;

    /**
     * AdminByUserAction constructor.
     * @param EntityManagerInterface $doctrine
     */
    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }


    public function __invoke(Request $request,AdminByUserResponder $responder)
    {
        $repository = $this->doctrine->getRepository(User::class);

        return $responder($repository->findOneBy([
            'id' => $request->attributes->get('id')
        ]));
    }

}