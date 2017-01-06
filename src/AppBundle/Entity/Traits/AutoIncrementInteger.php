<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

trait AutoIncrementInteger
{
    /**
     * System object identifier
     *
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", options={"unsigned": true})
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @JMS\Expose
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
