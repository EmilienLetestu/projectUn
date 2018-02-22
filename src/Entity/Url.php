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
 */
class Url
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $story = null;

    /**
     * @var
     */
    private $href = null;

    /**
     * @var null
     */
    private $alt = null;


    /**------------------------ setters and getters -------------------**/

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Story $story
     * @return Story
     */
    public function setStory(Story $story)
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
     * @param $href
     * @return mixed
     */
    public function setAlt($href)
    {
       $alt = $this->makeAlt($href);
       return $this->alt = $alt;
    }

    /**
     * @return null
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param $href
     * @return mixed
     */
    private function makeAlt($href)
    {
       $alt = parse_url($href);
       return $alt['host'];
    }
}

