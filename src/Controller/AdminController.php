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

    public function adminHome()
    {
        return $this->render('admin\admin.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminUser()
    {
        $userList = $this->get('App\Managers\UserManager')
            ->fetchUserForAdmin()
        ;

        return $this->render('admin\adminUser.html.twig',[
            'userList' => $userList
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminStory()
    {
        $storyList = $this->get('App\Managers\StoryManager')
            ->fetchStoryForAdmin()
        ;

        return $this->render('admin\adminStory.html.twig',[
            'storyList' => $storyList
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminTopic()
    {
        $topicList = $this->get('App\Managers\TopicManager')
            ->fetchTopicForAdmin();

        return $this->render('admin\adminTopic.html.twig',[
            'topicList' => $topicList
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminPatronage()
    {
        $patronageList = $this->get('App\Managers\PatronageManager')
            ->fetchPatronageForAdmin()
        ;

        return $this->render('admin\adminPatronage.html.twig',[
            'patronageList' => $patronageList
        ]);
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminByUser(Request $request)
    {
        $user = $this->get('App\Managers\UserManager')
            ->fetchOneUserForAdmin($request)
        ;

        return $this->render('admin\adminUserData.html.twig',[
            'user' => $user
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