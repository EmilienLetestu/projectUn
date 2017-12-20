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
        return $this->render('admin\admin.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminUser()
    {
        $userList = $this->get('App\Managers\UserManager')->fetchUserForAdmin();

        return $this->render('admin\adminUser.html.twig',[
            'userList' => $userList
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminStory()
    {
        $storyList = $this->get('App\Managers\StoryManager')->fetchStoryForAdmin();

        return $this->render('admin\adminStory.html.twig',[
            'storyList' => $storyList
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminTopic()
    {
        $topicList = $this->get('App\Managers\TopicManager')->fetchTopicForAdmin();

        return $this->render('admin\adminTopic.html.twig',[
            'topicList' => $topicList
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