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
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

final class StoryAction
{
    private $doctrine;

    /**
     * StoryAction constructor.
     * @param EntityManager $doctrine
     */
    public function __construct(EntityManager $doctrine)
    {
       $this->doctrine = $doctrine;
    }


    public function __invoke(Request $request, StoryResponder $responder)
    {
        $repoStory = $this->doctrine->getRepository(Story::class);
        $repoUrl   = $this->doctrine->getRepository(Url::class); //todo => try to access it through story
        $id        = $request->attributes->get('storyId');

        $story = $repoStory->findOneBy(['id'=>$id]);

        return $responder(
            $story,
            $repoStory->findAllWithSameTopic($story->getTopic()->getId(), $id),
            $repoStory->findAllWithSameCountry($story->getCountry(), $id),
            $repoStory->findAllWithSameYear($story->getYear(), $id),
            $repoStory->findAllWithSamePatronage($story->getPatronage()->getId(),$id),
            $repoUrl->findBy(['story'=>$id]),
            $repoStory->findNext($id),
            $repoStory->findPrevious($id)
        );

    }
}