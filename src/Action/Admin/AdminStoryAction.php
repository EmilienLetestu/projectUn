<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 11:41
 */

namespace App\Action\Admin;


use App\Managers\StoryManager;
use App\Responder\Admin\AdminStoryResponder;
use Symfony\Component\HttpFoundation\Request;

class AdminStoryAction
{
    /**
     * @var StoryManager
     */
    private $storyManager;

    /**
     * AdminStoryAction constructor.
     * @param StoryManager $storyManager
     */
    public function __construct(StoryManager $storyManager)
    {
        $this->storyManager = $storyManager;
    }

    /**
     * @param AdminStoryResponder $responder
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(AdminStoryResponder $responder, Request $request)
    {
        $filter   = $request->attributes->get('filter');
        $method = 'fetchStoryBy'.ucfirst($filter);

       return $responder(
            $filter !== null?
                $storyList = $this->storyManager->$method(
                    $request->attributes->get('filterId')) :
                $storyList = $this->storyManager->fetchStoryForAdmin()
       );
    }
}