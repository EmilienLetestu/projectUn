<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/01/2018
 * Time: 08:26
 */

namespace App\Action;


use App\Entity\Story;
use App\Entity\Url;
use App\Responder\StoryResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class StoryAction
{
    private $doctrine;

    /**
     * StoryAction constructor.
     * @param EntityManagerInterface $doctrine
     */
    public function __construct(EntityManagerInterface $doctrine)
    {
       $this->doctrine = $doctrine;
    }


    public function __invoke(Request $request, StoryResponder $responder)
    {
        $repoStory = $this->doctrine->getRepository(Story::class);
        $id        = $request->attributes->get('storyId');

        $story = $repoStory->findStory($id);

        return $responder(
            $story,
            $repoStory->findAllRelated(
                $story->getTopic()->getId(),
                $story->getCountry(),
                $story->getYear(),
                $story->getPatronage()->getId(),
                $id
            ),
            $repoStory->findNext($id),
            $repoStory->findPrevious($id)
        );

    }
}
