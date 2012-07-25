<?php
namespace Amadi\GeoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="geo_district")
 */
class District
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length="255")
     *
     * @var string $name
     */
    protected $name;

    /**
     * Страна
     * @ORM\ManyToOne(targetEntity="Amadi\GeoBundle\Entity\Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    private $countryId;

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
     */
    public function setName($name)
    {
        $this->name = $name;
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

    function __toString()
    {
        return $this->getName();
    }

    /**
     * Set countryId
     *
     * @param Amadi\GeoBundle\Entity\Country $countryId
     */
    public function setCountryId(\Amadi\GeoBundle\Entity\Country $countryId)
    {
        $this->countryId = $countryId;
    }

    /**
     * Get countryId
     *
     * @return Amadi\GeoBundle\Entity\Country
     */
    public function getCountryId()
    {
        return $this->countryId;
    }
}