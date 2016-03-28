<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * @ORM\Entity
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\ContactRepository")
 * @GRID\Source(columns="id,first_name,last_name,email,is_active")
 */
class Contact
{
    const SPACE = ' ';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="first_name",type="string", nullable=false)
     * @GRID\Column(field="first_name", type="text" , filterable=true, title="First Name",size=30)
     */
    private $first_name;

    /**
     * @ORM\Column(name="last_name",type="string", nullable=false)
     * @GRID\Column(field="last_name", type="text" , filterable=true, title="Last Name",size=30)
     */
    private $last_name;

    /**
     * @ORM\Column(name="email",type="string", nullable=false)
     * @GRID\Column(field="email", type="text" , filterable=true, title="Email",size=30)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", options={"default":true})
     * @GRID\Column(field="is_active", type="boolean" , filterable=false, title="Enable",size=10, sortable=false)
     */
    private $is_active;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     * @GRID\Column(field="is_unsubscribed", type="boolean" , filterable=false, title="Unsubcribed",size=10, sortable=false)
     */
    private $is_unsubscribed;

    /**
     * @ORM\Column(type="boolean",type="text", nullable=true)
     */
    private $unsubscribed_comment;

    /**
     * Contact constructor.
     */
    public function __construct() {
        $this->is_active = true;
        $this->is_unsubscribed = false;
    }

    public function getId() {
        return $this->id;
    }

    public function getCompleteName() {
        return $this->first_name . self::SPACE . $this->last_name;
    }

    public function getFirstLetter() {
        return strtoupper($this->first_name[0] . $this->last_name[0]);
    }

    public function setFirstName($firstName) {
        $this->first_name = $firstName;
        return $this;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function setLastName($lastName) {
        $this->last_name = $lastName;
        return $this;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * @param mixed $is_active
     */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
    }

    /**
     * @return mixed
     */
    public function getIsUnsubscribed()
    {
        return $this->is_unsubscribed;
    }

    /**
     * @param mixed $is_unsubscribed
     */
    public function setIsUnsubscribed($is_unsubscribed)
    {
        $this->is_unsubscribed = $is_unsubscribed;
    }

    /**
     * @return mixed
     */
    public function getUnsubscribedComment()
    {
        return $this->unsubscribed_comment;
    }

    /**
     * @param mixed $unsubscribed_comment
     */
    public function setUnsubscribedComment($unsubscribed_comment)
    {
        $this->unsubscribed_comment = $unsubscribed_comment;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

}
