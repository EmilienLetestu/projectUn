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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function adminDeleteUnactivated()
    {
        $this->get('App\Managers\UserManager')
            ->deleteAllUnactivatedAccount(' - 60 day')
        ;

        return $this->redirectToRoute('admin');
    }



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminTopic(Request $request)
    {
        $list = $this->get('App\Managers\TopicManager')
            ->fetchTopicForAdmin();

        $form = $this->get('App\Services\EditTopic')
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