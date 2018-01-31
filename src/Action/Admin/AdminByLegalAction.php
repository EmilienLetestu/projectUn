<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 12/01/2018
 * Time: 08:02
 */

namespace App\Action\Admin;


use App\Entity\Term;
use App\Responder\Admin\AdminByLegalResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AdminByLegalAction
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


    public function __invoke(Request $request,AdminByLegalResponder $responder)
    {
        $repository = $this->doctrine->getRepository(Term::class);

        return
            $responder(
                $repository->findWithId(
                    $request->attributes->get('id')
                )
        );
    }

}