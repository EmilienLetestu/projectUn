<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 15/10/17
 * Time: 10:49
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\Column(type="string", length=50)
     */
    private $href;

    /**
     * @var
     * @ORM\Column(type="string", length=20)
     */
    private $alt;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="App\Entity\Story", inversedBy="urls")
     * @ORM\JoinColumn(nullable=false)
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
     * @param mixed $href
     */
    public function setHref($href)
    {
        $this->href = $href;
    }

    /**
     * @return mixed
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param mixed $alt
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    }

    /**
     * @return mixed
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param mixed $story
     */
    public function setStory($story)
    {
        $this->story = $story;
    }


    /**
     * @return mixed
     */
    public function getStory()
    {
        return $this->story;
    }


}