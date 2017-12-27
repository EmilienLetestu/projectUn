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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminStory(Request $request)
    {
        $filter   = $request->attributes->get('filter');
        $method = 'fetchStoryBy'.ucfirst($filter);

        $filter !== null ?
            $storyList = $this->get('App\Managers\StoryManager')
                ->$method($request->attributes->get('filterId')) :
            $storyList = $this->get('App\Managers\StoryManager')
                ->fetchStoryForAdmin()
        ;

        return $this->render('admin\adminStory.html.twig',[
            'storyList' => $storyList
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminTopic(Request $request)
    {
        $builder = $this->get('App\Builders\AdminBuilder')
            ->buildAdminTopic($request);

        return $this->render('admin\adminTopic.html.twig',[
            'topicList' => $builder[0],
            'form'      => $builder[1]
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminPatronage(Request $request)
    {
        $builder = $this->get('App\Builders\AdminBuilder')
            ->buildAdminPatronage($request)
        ;

        return $this->render('admin\adminPatronage.html.twig',[
            'patronageList' => $builder[0],
            'form'          => $builder[1]
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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminByStory(Request $request)
    {
        $story = $this->get('App\Managers\StoryManager')
            ->fetchOneStoryForAdmin($request)
        ;

        return $this->render('admin\adminStoryData.html.twig',[
            'story' => $story
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminEditStory(Request $request)
    {
        $builder = $this->get('App\Builders\AdminBuilder')
            ->buildAdminEditStory($request)
        ;

        return $this->render('admin\adminEditStory.html.twig',[
           'story' => $builder[0],
           'form'  => $builder[1]
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function adminEntityManagement(Request $request)
    {
        $entity = $request->attributes->get('entity');
        $action = $request->attributes->get('action');

        $method = $action.ucfirst($entity);

        $entity === 'story' ?
            $process = $this->get('App\Managers\StoryManager')
                ->$method($request->attributes->get('id'))
            :
            $process = $this->get('App\Managers\UserManager')
                ->$method($request->attributes->get('id'))
        ;

        $this->get('session')->getFlashBag()->add('success',$process);

        return $this->redirectToRoute('admin'.ucfirst($entity));
    }

}