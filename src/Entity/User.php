<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
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
     * @ORM\OneToMany(targetEntity="Friendship", mappedBy="user",cascade={"persist"})
     */
    private $friends;

    /**
     * The people who think that I’m their friend (when they accept)
     *
     * @ORM\OneToMany(targetEntity="Friendship", mappedBy="friend",cascade={"persist"})
     */
    private $friendsWithMe;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="date")
     */
    private $birth;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct()
    {
      $this->isActive = true;
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
        $fs->setDate(new \DateTime(date("Y-m-d H:i:s")));

        $this->addFriendship($fs);

        return $this;
    }


    /**
     * Get the value of The people who I think are my friends.
     *
     * @return mixed
     */
    public function getFriends($em)
    {

        $fs = $em->getRepository(Friendship::class)->findByUser($this->id);
        $friends = $em->getRepository(User::class)->findById($fs);

        /* This method also gets current user as a friend, dirty fix for now*/
        if(isset($friends[0]) && $friends[0]->id == $this->id) {
          unset($friends[0]);
        }

        return $friends;
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


    /**
     * Get the value of Password
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of Password
     *
     * @param mixed password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of Email
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of Email
     *
     * @param mixed email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }



    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

}
