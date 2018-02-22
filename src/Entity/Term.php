<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 11/01/2018
 * Time: 21:05
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class Term
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $title;

    /**
     * @var
     */
    private $article;

    /**
     * @var
     */
    private $status;

    /**
     * @var
     */
    private $createdOn;

    /**
     * @var
     */
    private $publishedOn = null;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $format
     * @return \DateTime
     */
    public function setCreatedOn($format)
    {
        return $this->createdOn = new \DateTime(date($format));
    }

    /**
     * @return mixed
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param $format
     * @return \DateTime
     */
    public function setPublishedOn($format)
    {
        return $this->publishedOn = new \DateTime(date($format));
    }

    /**
     * @return mixed
     */
    public function getPublishedOn()
    {
        return $this->publishedOn;
    }


}

