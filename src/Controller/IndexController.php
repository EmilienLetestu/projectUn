<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 11/10/17
 * Time: 16:19
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class IndexController extends Controller
{


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function browse(Request $request)
    {
        $view = $this->get('App\Builders\BrowserBuilder')
            ->buildBrowser($request,5)
        ;

        return $this->render('pagination.html.twig',[
             'stories'    => $view[0],
             'pageNumber' => $view[1],
             'totalPage'  => $view[2],
             'filter'     => $view[3],
             'title'      => $view[4],
             'country'    => $view[5],
             'topic'      => $view[6],
             'patronage'  => $view[7],
             'worldArea'  => $view[8]
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function search(Request $request)
    {
        $view = $this->get('App\Managers\StoryManager')
            ->processFilterForm($request)
        ;

        if($view[0] === 'all' && $view[1] === 'all' && $view[2] === 'all' && $view[3] === 'all')
        {
            return $this->redirect($this->generateUrl('browse',[
                'pageNumber'=>1
                ]));
        }

        return $this->redirect($this->generateUrl('browse',[
            'pageNumber'=>1,
            'worldArea' => $view[0],
            'country'   => $view[1],
            'topic'     => $view[2],
            'patronage' => $view[3]
        ]));
    }
}

