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
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class AdminByUserAction
{
    /**
     * @var EntityManager
     */
    private $doctrine;

    /**
     * AdminByUserAction constructor.
     * @param EntityManager $doctrine
     */
    public function __construct(EntityManager $doctrine)
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