<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 * @ORM\Table(name="image")
 * @JMS\ExclusionPolicy("all")
 */
class Image
{
    use Traits\AutoIncrementInteger;
    use Traits\Enableable;
    use Traits\Timestampable;

    /**
     * Title of image
     *
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="title", type="string", length=100, nullable=false)
     * @JMS\Expose
     */
    private $title;

    /**
     * Description of image
     *
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     * @JMS\Expose
     */
    private $description;

    /**
     * URL of image
     *
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Image()
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     * @JMS\Expose
     */
    private $url;

    /**
     * Thumbnail URL of image
     *
     * @var string
     *
     * @ORM\Column(name="thumbnail_url", type="string", length=255, nullable=true)
     * @JMS\Expose
     */
    private $thumbnailUrl;

    /**
     * @var \AppBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", inversedBy="images")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->enabled = true;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Image
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Image
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set thumbnailUrl
     *
     * @param string $url
     * @return Image
     */
    public function setThumbnailUrl($thumbnailUrl)
    {
        $this->thumbnailUrl = $thumbnailUrl;

        return $this;
    }

    /**
     * Get thumbnailUrl
     *
     * @return string
     */
    public function getThumbnailUrl()
    {
        return $this->thumbnailUrl;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     * @return Image
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

}
