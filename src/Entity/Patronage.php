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
 * @ORM\Entity
 * @ORM\Table(name="patronage")
 */
class Patronage
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
     * @ORM\Column(type="string", length=30)
     */
    private $organization;


    /**
     * @var
     * @ORM\OneToMany(targetEntity="App\Entity\Story", mappedBy="patronage")
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

}

