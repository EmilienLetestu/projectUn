<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 15/10/17
 * Time: 10:49
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Url
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="url")
 */
class Url
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
     * @ORM\Column(type="string", length=200,nullable=true)
     */
    private $href=null;

    /**
     * @var
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $alt=null;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="App\Entity\Story", inversedBy="urls")
     * @ORM\JoinColumn(name="story_id", referencedColumnName="id")
     */
    private $story;


    /**------------------------ setters and getters -------------------**/

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $href
     * @return $this
     */
    public function setHref($href)
    {
       return $this->href = $href;
    }

    /**
     * @return mixed
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param $alt
     * @return $this
     */
    public function setAlt($alt)
    {
       return $this->alt = $alt;
    }

    /**
     * @return mixed
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param $story
     * @return mixed
     */
    public function setStory($story)
    {
       return $this->story = $story;
    }


    /**
     * @return mixed
     */
    public function getStory()
    {
        return $this->story;
    }


}