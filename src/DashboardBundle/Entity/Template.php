<?php

namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * @ORM\Entity
 * @ORM\Table(name="templates")
 * @GRID\Source(columns="id,name,image")
 */
class Template
{
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @GRID\Column(field="name", type="text" , filterable=false, title="Name",size=25)
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $view;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @GRID\Column(field="image", type="photo" , filterable=false, title="Image",size=25)
     */
    private $image;

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
     * Set name
     *
     * @param string $name
     * @return Template
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set view
     *
     * @param string $view
     * @return Template
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return string 
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Template
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }
}
