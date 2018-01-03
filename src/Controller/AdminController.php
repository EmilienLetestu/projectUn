<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/12/2017
 * Time: 14:06
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminPatronage(Request $request)
    {
        $list = $this->get('App\Managers\PatronageManager')
            ->fetchPatronageForAdmin();

        $form = $this->get('App\Services\EditPatronage')
            ->processPatronage($request);

        if($this->get('session')->get('added')) {

            $this->get('session')->remove('added');
            return $this->redirectToRoute('adminPatronage');
        }

        return $this->render('admin\adminPatronage.html.twig',[
            'patronageList' => $list,
            'form'          => $form
        ]);
    }


}