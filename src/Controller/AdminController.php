<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/12/2017
 * Time: 14:06
 */

namespace App\Controller;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
    public function updateRoleAction()
    {
        $id = $this->request->query->get('id');
        $entity = $this->em->getRepository(User::class)->find($id);

        if($entity->getRole() === 'ADMIN')
        {
            $this->addFlash('denied',
                'you can\'t update administrator privileges'
            );
            return $this->redirectToRoute('admin',[
                'action' => 'show',
                'entity' => $this->request->query->get('entity'),
                'id' => $id
            ]);
        }

        $entity->getRole() === 'EDIT' ?
            $entity->setRole('USER') :
            $entity->setRole('EDIT')
        ;

        $this->em->flush();

        $this->addFlash('succes',
            $entity->getFullname().'User has been granted '.$entity->getRole().' privileges'
        );

        return $this->redirectToRoute('admin',[
            'action' => 'show',
            'entity' => $this->request->query->get('entity'),
            'id' => $id
        ]);
    }
}