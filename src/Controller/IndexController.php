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

class IndexController extends Controller
{
    public function home(Request $request)
    {
        $view = $this->get('App\Managers\StoryManager')->fetchForBrowsing();

       $repo = $this->getDoctrine()->getRepository(Story::class);
        $t =$repo->finAllWithSamePatronage($organization = 1);

        dump($t);

        return $this->render('home.html.twig',[
            'storyList'=>$view]
        );
    }

    public function story(Request $request)
    {
        $view = $this->get('App\Managers\StoryManager')->fetchForReading($request);

        return $this->render('story.html.twig',[
            'story'       => $view[0],
            'sameTopic'   => $view[1],
            'sameCountry' => $view[2],
            'sameYear'    => $view[3]
            ]
        );
    }

    public function addStory(Request $request)
    {
        $view = $this->get('App\Services\AddStory')->processAndAdd($request);

        return $this->render('addStory.html.twig',[
                'form'=>$view]
        );
    }
}