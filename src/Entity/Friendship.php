<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FriendshipRepository")
 */
 class Friendship
 {
     /**
      * @ORM\ManyToOne(targetEntity="User", inversedBy="friends")
      * @ORM\Id
      */
     private $user;

     /**
      * @ORM\ManyToOne(targetEntity="User", inversedBy="friendsWithMe")
      * @ORM\Id
      */
     public $friend;

     /**
      * Example of an additional attribute.
      *
      * @ORM\Column(type="datetime")
      */
     private $date;

     // …

    /**
     * Get the value of User
     *
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of User
     *
     * @param mixed user
     *
     * @return self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of Friend
     *
     * @return mixed
     */
    public function getFriend()
    {
        return $this->friend;
    }

    /**
     * Set the value of Friend
     *
     * @param mixed friend
     *
     * @return self
     */
    public function setFriend($friend)
    {
        $this->friend = $friend;

        return $this;
    }

    /**
     * Get the value of Example of an additional attribute.
     *
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of Example of an additional attribute.
     *
     * @param mixed date
     *
     * @return self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

}
