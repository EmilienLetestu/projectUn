<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 16:06
 */

namespace App\Action\Admin;


use App\Entity\Topic;
use App\Responder\Admin\AdminTopicResponder;
use App\Services\EditTopic;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminTopicAction
{
    private $doctrine;
    private $editTopic;
    private $session;

    public function __construct(
        EntityManager $doctrine,
        EditTopic     $editTopic,
        Session       $session
    )
    {
        $this->doctrine  = $doctrine;
        $this->editTopic = $editTopic;
        $this->session   = $session;
    }

    public function __invoke(Request $request, AdminTopicResponder $responder)
    {
       $repository = $this->doctrine->getRepository(Topic::class);

       $form = $this->editTopic->processTopic($request);

       if($this->session->get('added')) {
           $this->session->remove('added');
           return new RedirectResponse('/admin/topic');
       }

       return $responder($repository->findAll(),$form);
    }
}