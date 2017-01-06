<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 * @ORM\Table(name="category")
 * @JMS\ExclusionPolicy("all")
 */
class Category
{
    use Traits\AutoIncrementInteger;
    use Traits\Enableable;
    use Traits\Timestampable;

    /**
     * Name of category
     *
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     * @JMS\Expose
     */
    private $name;

    /**
     * @var Image[]
     *
     * @ORM\OneToMany(targetEntity="Image", mappedBy="category")
     */
    private $images;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->enabled = true;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get images
     *
     * @return Image[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add image
     *
     * @param \AppBundle\Entity\Image $image
     * @return Application
     */
    public function addImage(\AppBundle\Entity\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \Purina\CoreBundle\Entity\Image $image
     */
    public function removeImage(\AppBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

}