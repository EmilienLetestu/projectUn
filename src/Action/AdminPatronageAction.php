<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 16:58
 */

namespace App\Action;


use App\Entity\Patronage;
use App\Responder\AdminPatronageResponder;
use App\Services\EditPatronage;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

final class AdminPatronageAction
{
    private $doctrine;
    private $editPatronage;
    private $session;

    /**
     * AdminPatronageAction constructor.
     * @param EntityManager $doctrine
     * @param EditPatronage $editPatronage
     * @param Session $session
     */
    public function __construct(
        EntityManager $doctrine,
        EditPatronage $editPatronage,
        Session       $session
    )
    {
      $this->doctrine      = $doctrine;
      $this->editPatronage = $editPatronage;
      $this->session       = $session;
    }

    /**
     * @param Request $request
     * @param AdminPatronageResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AdminPatronageResponder $responder)
    {
        $repository = $this->doctrine->getRepository(Patronage::class);

        $form = $this->editPatronage->processPatronage($request);

        if($this->session->get('added')){
            $this->session->remove('added');
            return new RedirectResponse('/admin/patronage');
        }

       return $responder($repository->findAll(),$form);
    }
}
