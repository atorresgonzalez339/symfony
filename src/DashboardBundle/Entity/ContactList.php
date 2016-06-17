<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * @ORM\Entity
 * @ORM\Table(name="contact_list")
 * @ORM\Entity(repositoryClass="DashboardBundle\Repository\ContactListRepository")
 * @GRID\Source(columns="id,name")
 */
class ContactList
{
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="name",type="string", nullable=false)
     * @GRID\Column(field="name", type="text" , filterable=true, title="Name",size=100, operatorsVisible=false)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="Contact")
     * @ORM\JoinTable(name="contactlist_contact",
     *     joinColumns={@ORM\JoinColumn(name="idcontactlist", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="idcontact", referencedColumnName="id")})
     */
    protected $contacts;

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getUser() {
        return $this->user;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setUser($user) {
        $this->user = $user;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contacts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add contacts
     *
     * @param \DashboardBundle\Entity\Contact $contacts
     * @return ContactList
     */
    public function addContact(\DashboardBundle\Entity\Contact $contacts)
    {
        $this->contacts[] = $contacts;

        return $this;
    }

    /**
     * Remove contacts
     *
     * @param \DashboardBundle\Entity\Contact $contacts
     */
    public function removeContact(\DashboardBundle\Entity\Contact $contacts)
    {
        $this->contacts->removeElement($contacts);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContacts()
    {
        return $this->contacts;
    }
}
