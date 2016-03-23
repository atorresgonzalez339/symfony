<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * @ORM\Entity
 * @ORM\Table(name="contact")
 * @GRID\Source(columns="id,first_name,last_name,email")
 */
class Contact
{
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="first_name",type="string", nullable=false)
     */
    private $first_name;

    /**
     * @ORM\Column(name="last_name",type="string", nullable=false)
     */
    private $last_name;

    /**
     * @ORM\Column(name="email",type="integer", nullable=false)
     */
    private $email;

    public function getId() {
        return $this->id;
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
}
