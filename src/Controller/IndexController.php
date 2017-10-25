<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 11/10/17
 * Time: 16:19
 */

namespace App\Controller;

use App\Entity\Story;
use App\Entity\Topic;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class IndexController extends Controller
{
    public function home()
    {
        $view = $this->get('App\Managers\StoryManager')->fetchForHome();
        return $this->render('home.html.twig',[
            'stories'=>$view[0],
            'total'  =>$view[1]
            ]
        );
    }

    /**
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        $view = $this->get('App\Services\Login')->processLogin($request, $authUtils);

        if($view === 'home')
        {
            return $this->redirectToRoute($view);
        }

        return $this->render('connectionForms.html.twig',[
                'last_username' =>$view[0],
                'error' => $view[1]]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function story(Request $request)
    {
        $view = $this->get('App\Managers\StoryManager')->fetchForReading($request);

        return $this->render('story.html.twig',[
            'story'         => $view[0],
            'sameTopic'     => $view[1],
            'sameCountry'   => $view[2],
            'sameYear'      => $view[3],
            'samePatronage' => $view[4],
            'extResources'  => $view[5]
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addStory(Request $request)
    {
        $view = $this->get('App\Services\AddStory')
            ->processAndAdd($request)
        ;

        return $this->render('addStory.html.twig',[
            'form'=>$view
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request)
    {
        $view = $this->get('App\Services\Register')
            ->registerUser($request)
        ;

        if($view === 'home')
        {
            return $this->redirectToRoute($view);
        }

        return $this->render('connectionForms.html.twig',[
            'form' => $view
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activation(Request $request)
    {
        $this->get('App\Services\Activation')
             ->ActivateUserAccount($request)
        ;

        return $this->redirectToRoute('home');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newPswdMail(Request $request)
    {
        $view = $this->get('App\Services\RenewPswd')
            ->askNew($request)
        ;

        return $this->render('connectionForms.html.twig',[
            'form'=>$view
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newPswdProcess(Request $request)
    {
        $view = $this->get('App\Services\RenewPswd')
            ->newPswd($request)
        ;

        if($view === 'home')
        {
            return $this->redirectToRoute($view);
        }

        return $this->render('connectionForms.html.twig',[
            'form'=> $view
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function browse(Request $request)
    {
        $view = $this->get('App\Managers\StoryManager')
            ->fetchForBrowser(
            $request,
            $limit = 5)
        ;
        return $this->render('pagination.html.twig',[
             'stories'    => $view[0],
             'pageNumber' => $view[1],
             'totalPage'  => $view[2],
             'filter'     => $view[3],
             'title'      => $view[4]
            ]
        );
    }

}