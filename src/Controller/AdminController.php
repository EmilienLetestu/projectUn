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
        return $this->render('admin\adminUser.html.twig',[
            'userList' => $this->get('App\Managers\UserManager')
                ->fetchUserForAdmin()
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
            'storyList' => $storyList[0],
            'title'     => $storyList[1]
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminTopic(Request $request)
    {
        $list = $this->get('App\Managers\TopicManager')
            ->fetchTopicForAdmin();

        $form = $this->get('App\Services\AddTopic')
            ->processTopic($request);

        if($this->get('session')->get('added'))
        {
            $this->get('session')->remove('added');
            return $this->redirectToRoute('adminTopic');
        }

        return $this->render('admin\adminTopic.html.twig',[
            'topicList' => $list,
            'form'      => $form
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminPatronage(Request $request)
    {
        $list = $this->get('App\Managers\PatronageManager')
            ->fetchPatronageForAdmin();

        $form = $this->get('App\Services\AddPatronage')
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


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminByUser(Request $request)
    {
        return $this->render('admin\adminUserData.html.twig',[
            'user' => $this->get('App\Managers\UserManager')
                ->fetchOneUserForAdmin(
                    $request->attributes->get('id')
                )
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminByStory(Request $request)
    {
        return $this->render('admin\adminStoryData.html.twig',[
            'story' => $this->get('App\Managers\StoryManager')
                ->fetchOneStoryForAdmin(
                    $request->attributes->get('id')
                )
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminEditStory(Request $request)
    {
        $story = $this->get('App\Managers\StoryManager')
            ->fetchOneStoryForAdmin($request->attributes->get('id'))
        ;

        $form = $this->get('App\Services\EditStory')
            ->processAndEdit($request, $story)
        ;

        return $this->render('admin\adminEditStory.html.twig',[
           'story' => $story,
           'form'  => $form
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