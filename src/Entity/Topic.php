<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 11/10/17
 * Time: 21:50
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Topic
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="topic")
 */
class Topic implements \Serializable
{
    /**
     * @var
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var
     * @ORM\Column(type="string", length=20)
     */
    private $type;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="App\Entity\Story", mappedBy="topic", cascade={"persist", "remove"})
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
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**------------------------ relation management -------------------**/

    /**
     * Topic constructor.
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
            $this->getType(),
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->type
            ) = unserialize($serialized)
        ;
    }
}