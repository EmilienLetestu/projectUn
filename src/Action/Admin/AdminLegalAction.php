<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 12/01/2018
 * Time: 07:13
 */

namespace App\Action\Admin;


use App\Entity\Term;
use App\Responder\Admin\AdminLegalResponder;
use Doctrine\ORM\EntityManagerInterface;

class AdminLegalAction
{
    private $doctrine;

    /**
     * AdminLegalAction constructor.
     * @param EntityManagerInterface $doctrine
     */
    public  function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param AdminLegalResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(AdminLegalResponder $responder)
    {
        $repository = $this->doctrine->getRepository(Term::class);

        return $responder($repository->findAll());
    }
}