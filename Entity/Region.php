<?php
namespace Amadi\GeoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="geo_region")
 */
class Region
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
     * @ORM\Column(type="string", length="128")
     */
    private $region;

    /**
     * Округ
     * @ORM\ManyToOne(targetEntity="District")
     * @ORM\JoinColumn(name="district", referencedColumnName="id")
     */
    private $district;

    /**
     * Get region_id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set region
     *
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set district
     *
     * @param Amadi\GeoBundle\Entity\District $district
     */
    public function setDistrict(\Amadi\GeoBundle\Entity\District $district)
    {
        $this->district = $district;
    }

    /**
     * Get district
     *
     * @return Amadi\GeoBundle\Entity\District
     */
    public function getDistrict()
    {
        return $this->district;
    }

    public function __toString(){
        return $this->getRegion();
    }
}