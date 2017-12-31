<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 15/10/17
 * Time: 10:47
 */

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Patronage
 * @package App\Entity
 */
class Patronage implements \Serializable
{
    /**
     * @var
     */
    private $id;


    /**
     * @var
     */
    private $organization;


    /**
     * @var
     */
    private $stories;

    /**------------------------ setters and getters -------------------**/

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $organization
     * @return mixed
     */
    public function setOrganization($organization)
    {
       return $this->organization = $organization;
    }


    /**
     * @return mixed
     */
    public function getOrganization()
    {
        return $this->organization;
    }


    /**------------------------ relation management -------------------**/

    /**
     * Patronage constructor.
     */
    public function __construct()
    {
        $this->stories = new ArrayCollection();
    }

    /**
     * @param Story $story
     * @return $this
     */
    public function addStory(Story $story)
    {
        $this->stories[] = $story;

        return $this;
    }

    /**
     * @param Story $story
     */
    public function removeStory(Story $story)
    {
        $this->stories->removeElement($story);
    }

    /**
     * @return ArrayCollection
     */
    public function getStories()
    {
        return $this->stories;
    }

    /**---------------------- serialize------------------------*/

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize([
            $this->getId(),
            $this->getOrganization(),
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->organization
            ) = unserialize($serialized)
        ;
    }
}


