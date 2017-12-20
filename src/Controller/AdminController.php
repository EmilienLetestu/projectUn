<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/12/2017
 * Time: 14:06
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{

    public function adminHome()
    {
        return $this->render('admin/admin.html.twig');
    }

    public function adminUser()
    {
        $userList = $this->get('App\Managers\UserManager')->getAllUser();

        return $this->render('admin/adminUser.html.twig',[
            'userList' => $userList
        ]);
    }



    /**public function updateRoleAction()
    {
        $id = $this->request->query->get('id');

        $this->get('App\Managers\UserManager')
            ->updateUserRole($id)
        ;

        return $this->redirectToRoute('admin',[
            'action' => 'show',
            'entity' => $this->request->query->get('entity'),
            'id' => $id
        ]);
    }*/

}