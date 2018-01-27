<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * The people who I think are my friends.
     *
     * @ORM\OneToMany(targetEntity="Friendship", mappedBy="user")
     */
    private $friends;

    /**
     * The people who think that I’m their friend.
     *
     * @ORM\OneToMany(targetEntity="Friendship", mappedBy="friend")
     */
    private $friendsWithMe;


    // add your own fields

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $last_name;

    /**
     * @ORM\Column(type="date")
     */
    private $birth;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    public function __construct()
    {
      $this->friends = new ArrayCollection();
      $this->friendsWithMe = new ArrayCollection();
    }

    public function addFriendship(Friendship $friendship)
    {
        $this->friends->add($friendship);
        $friendship->friend->addFriendshipWithMe($friendship);
    }

    public function addFriendshipWithMe(Friendship $friendship)
    {
        $this->friendsWithMe->add($friendship);
    }

    public function addFriend(User $friend)
    {
        $fs = new Friendship();
        $fs->setUser($this);
        $fs->setFriend($friend);
        // set defaults
        $fs->setHasBeenHelpful(true);

        $this->addFriendship($fs);
    }

    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of First Name
     *
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set the value of First Name
     *
     * @param mixed first_name
     *
     * @return self
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get the value of Last Name
     *
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set the value of Last Name
     *
     * @param mixed last_name
     *
     * @return self
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Get the value of Birth
     *
     * @return mixed
     */
    public function getBirth()
    {
        return $this->birth;
    }

    /**
     * Set the value of Birth
     *
     * @param mixed birth
     *
     * @return self
     */
    public function setBirth($birth)
    {
        $this->birth = $birth;

        return $this;
    }

    /**
     * Get the value of Img
     *
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set the value of Img
     *
     * @param mixed img
     *
     * @return self
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }


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
     * Set the value of Id
     *
     * @param mixed id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of The people who I think are my friends.
     *
     * @return mixed
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * Set the value of The people who I think are my friends.
     *
     * @param mixed friends
     *
     * @return self
     */
    public function setFriends($friends)
    {
        $this->friends = $friends;

        return $this;
    }

    /**
     * Get the value of The people who think that I’m their friend.
     *
     * @return mixed
     */
    public function getFriendsWithMe()
    {
        return $this->friendsWithMe;
    }

    /**
     * Set the value of The people who think that I’m their friend.
     *
     * @param mixed friendsWithMe
     *
     * @return self
     */
    public function setFriendsWithMe($friendsWithMe)
    {
        $this->friendsWithMe = $friendsWithMe;

        return $this;
    }

}
