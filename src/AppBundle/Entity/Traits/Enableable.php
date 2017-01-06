<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

trait Enableable
{
    /**
     * Enabled/disabled
     *
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     * @JMS\Expose
     * @JMS\Groups({"admin"})
     */
    protected $enabled = true;

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }
}
