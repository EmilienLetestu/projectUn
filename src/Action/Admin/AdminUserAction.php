<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 10:13
 */

namespace App\Action\Admin;


use App\Entity\User;
use App\Responder\Admin\AdminUserResponder;
use Doctrine\ORM\EntityManager;

final class AdminUserAction
{
    /**
     * @var EntityManager
     */
    private $doctrine;

    /**
     * AdminUserAction constructor.
     * @param EntityManager $doctrine
     */
    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param AdminUserResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(AdminUserResponder $responder)
    {
        $repository = $this->doctrine->getRepository(User::class);

        return $responder($repository->findAll());
    }
}