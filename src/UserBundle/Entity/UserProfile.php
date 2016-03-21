<?php
namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use UserBundle\DBAL\Types\GenderType;

/**
 * @ORM\Entity(repositoryClass="UserBundle\Entity\Repository\UserProfileRepository")
 * @ORM\Table(name="user_profile")
 */
class UserProfile
{
    public function __construct(User $user){
        $this->user = $user;
        $this->is_completed = false;
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="cart")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $last_name;

    /**
     * @ORM\Column(name="position", type="GenderType", nullable=false)
     * @DoctrineAssert\Enum(entity="UserBundle\DBAL\Types\GenderType")     
     */
    private $gender;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $birth_date;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $cell_phone;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $office_phone;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $company;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $photo_id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $photo_url;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $is_completed;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set first_name
     *
     * @param string $firstName
     * @return UserProfile
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     * @return UserProfile
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set gender
     *
     * @param GenderType $gender
     * @return UserProfile
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return GenderType 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birth_date
     *
     * @param \DateTime $birthDate
     * @return UserProfile
     */
    public function setBirthDate($birthDate)
    {
        $this->birth_date = $birthDate;

        return $this;
    }

    /**
     * Get birth_date
     *
     * @return \DateTime 
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    /**
     * Set cell_phone
     *
     * @param string $cellPhone
     * @return UserProfile
     */
    public function setCellPhone($cellPhone)
    {
        $this->cell_phone = $cellPhone;

        return $this;
    }

    /**
     * Get cell_phone
     *
     * @return string 
     */
    public function getCellPhone()
    {
        return $this->cell_phone;
    }

    /**
     * Set office_phone
     *
     * @param string $officePhone
     * @return UserProfile
     */
    public function setOfficePhone($officePhone)
    {
        $this->office_phone = $officePhone;

        return $this;
    }

    /**
     * Get office_phone
     *
     * @return string 
     */
    public function getOfficePhone()
    {
        return $this->office_phone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return UserProfile
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set company
     *
     * @param string $company
     * @return UserProfile
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return UserProfile
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return UserProfile
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return UserProfile
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return UserProfile
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return UserProfile
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     * @return UserProfile
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getPhotoId()
    {
        return $this->photo_id;
    }

    /**
     * @param mixed $photo_id
     */
    public function setPhotoId($photo_id)
    {
        $this->photo_id = $photo_id;
    }

    /**
     * @return mixed
     */
    public function getPhotoUrl()
    {
        return $this->photo_url;
    }

    /**
     * @param mixed $photo_url
     */
    public function setPhotoUrl($photo_url)
    {
        $this->photo_url = $photo_url;
    }

    public function getFullName(){
        return $this->first_name . ' ' . $this->last_name;
    }
    /**
     * @return mixed
     */
    public function getIsCompleted()
    {
        return $this->is_completed;
    }
    /**
     * @param mixed $is_completed
     */
    public function setIsCompleted($is_completed)
    {
        $this->is_completed = $is_completed;
    }
}
