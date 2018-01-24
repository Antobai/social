<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{

    /**
    * @ORM\ManyToMany(targetEntity="User", mappedBy="friends")
    */
    private $friendsWithMe;

    /**
    * @ORM\ManyToMany(targetEntity="User", inversedBy="friendsWithMe")
    * @ORM\JoinTable(name="friends",
    *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="friend_user_id", referencedColumnName="id")}
    *      )
    */
    private $friends;



    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

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

}
