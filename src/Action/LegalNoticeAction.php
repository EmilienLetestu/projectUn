<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 15/01/2018
 * Time: 08:43
 */

namespace App\Action;


use App\Entity\Term;
use App\Responder\LegalNoticeResponder;
use Doctrine\ORM\EntityManagerInterface;

class LegalNoticeAction
{
    private $doctrine;

    /**
     * LegalNoticeAction constructor.
     * @param EntityManagerInterface $doctrine
     */
    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param LegalNoticeResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(LegalNoticeResponder $responder)
    {

        return($responder(
            $this->doctrine
                 ->getRepository(Term::class)
                 ->findAllWithStatus('published')
        ));
    }
}