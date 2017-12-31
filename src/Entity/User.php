<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 15/10/17
 * Time: 16:10
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Class User
 * @package App\Entity
 */
class User implements AdvancedUserInterface, \Serializable
{

    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $name;

    /**
     * @var
     */
    private $surname;

    /**
     * @var
     */
    private $email;

    /**
     * @var
     */
    private $pswd;

    /**
     * @var
     */
    private $role;

    /**
     * @var
     */
    private $registeredOn;

    /**
     * @var
     */
    private $profession;

    /**
     * @var
     */
    private $engagement;

    /**
     * @var
     */
    private $claimEdit;

    /**
     * @var
     */
    private $beenProcessed;

    /**
     * @var
     */
    private $activated = false;

    /**
     * @var bool
     */
    private $deactivated =false;

    /**
     * @var
     */
    private $confirmationToken;

    /**
     * @var
     */
    private $stories;

    /**
     * @var
     */
    private $notifications;

    /**---------------------- setters & getters ------------------------*/

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
       return $this->name = ucfirst(strip_tags(mb_strtolower($name)));

    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $surname
     * @return User
     */
    public function setSurname($surname)
    {
        return $this->surname = ucfirst(strip_tags(mb_strtolower($surname)));
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
      return  $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * @param string $pswd
     * @return User
     */
    public function setPswd($pswd)
    {
       return $this->pswd = password_hash($pswd, PASSWORD_BCRYPT);
    }


    /**
     * @return mixed
     */
    public function getPswd()
    {
        return $this->pswd;
    }

    /**
     * @param $role
     * @return User
     */
    public function setRole($role)
    {
      return  $this->role = strtoupper($role);
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param $claimEdit
     * @return mixed
     */
    public function setClaimEdit($claimEdit)
    {
        return $this->claimEdit = $claimEdit;
    }

    /**
     * @return mixed
     */
    public function getClaimEdit()
    {
        return $this->claimEdit;
    }

    /**
     * @param mixed $beenProcessed
     */
    public function setBeenProcessed($beenProcessed)
    {
        $this->beenProcessed = $beenProcessed;
    }

    /**
     * @return mixed
     */
    public function getBeenProcessed()
    {
        return $this->beenProcessed;
    }

    /**
     * @param $format
     * @return User
     */
    public function setRegisteredOn($format)
    {
       return $this->registeredOn = new \DateTime(date($format));
    }

    /**
     * @param mixed $profession
     */
    public function setProfession($profession)
    {
        $this->profession = $profession;
    }

    /**
     * @return mixed
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * @param mixed $engagement
     */
    public function setEngagement($engagement)
    {
        $this->engagement = $engagement;
    }

    /**
     * @return mixed
     */
    public function getEngagement()
    {
        return $this->engagement;
    }

    /**
     * @return mixed
     */
    public function getRegisteredOn()
    {
        return $this->registeredOn;
    }

    /**
     * @param $activated
     * @return User
     */
    public function setActivated($activated)
    {
       return $this->activated = $activated;

    }

    /**
     * @return mixed
     */
    public function getActivated()
    {
        return $this->activated;
    }

    /**
     * @param $deactivated
     * @return User
     */
    public function setDeactivated($deactivated)
    {
       return $this->deactivated = $deactivated;
    }

    public function getDeactivated()
    {
        return $this->deactivated;
    }

    /**
     * @return mixed
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * @param int $length
     * @return User
     */
    public function setConfirmationToken($length)
    {
        $confirmationToken = $this->generateConfirmationToken($length);
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**---------------------- entity relation management------------------------*/

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->stories = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    /**
     * @param Story $story
     */
    public function addStory(Story $story)
    {
        $this->stories[] = $story;
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

    /**
     * @param Notification $notification
     * @return $this
     */
    public function addNotification(Notification $notification)
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * @param Notification $notification
     */
    public function removeNotification(Notification $notification)
    {
        $this->notifications->removeElement($notification);
    }

    /**
     * @return mixed
     */
    public function getNotifications()
    {
        return $this->notifications;
    }


    /**---------------------- advanceUserInterface methods------------------------*/

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function getPassword()
    {
        return $this->getPswd();
    }

    public function getRoles()
    {
       $role = $this->getRole();

        return ["ROLE_{$role}"];
    }

    /**
     * default method from advanceUserInterface,
     * must be declare even blank
     */
    public function eraseCredentials()
    {

    }

    /**
     * return null as pswd use bcrypt algorithm
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return bool
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * @return mixed
     */
    public function isAccountNonLocked()
    {

        return $this->getDeactivated() ? false : true;
    }

    /**
     * @return mixed
     */
    public function isEnabled()
    {
       return $this->getActivated();
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize([
            $this->getId(),
            $this->getName(),
            $this->getSurname(),
            $this->getEmail(),
            $this->getRole(),
            $this->getStories()
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->name,
            $this->surname,
            $this->email,
            $this->role,
            $this->stories
            ) = unserialize($serialized)
        ;
    }

    /**
     * @return bool
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**---------------------- private methods------------------------*/

    /**
     * @param int $length
     * @return string
     */
    private function generateConfirmationToken(int $length) :string
    {
        $strToRandom = ('abcdefghijklmnoptqrdtuvwxyABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
        return substr(str_shuffle(str_repeat($strToRandom, $length)), 0, $length);
    }

    /**---------------------- view methods------------------------*/

    public function getFullName()
    {
        return $this->getName().' '.$this->getSurname();
    }

}
