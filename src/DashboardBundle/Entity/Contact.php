<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * @ORM\Entity
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\ContactRepository")
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
     * @GRID\Column(field="email", type="text" , filterable=true, title="Email",size=40)
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
