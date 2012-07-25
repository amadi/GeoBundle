<?php
namespace Amadi\GeoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="geo_base")
 * @ORM\Entity(repositoryClass="Amadi\GeoBundle\Entity\IpRepository")
 */
class Ip
{
    /**
     * @ORM\Id
     * @ORM\Column(name="long_ip1", type="bigint", nullable=false)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $long_ip1;

    /**
     * @ORM\Id
     * @ORM\Column(name="long_ip2", type="bigint", nullable=false)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $long_ip2;

    /**
    * @ORM\Column(type="string", length="16")
     */
    private $ip1;

    /**
     * @ORM\Column(type="string", length="16")
     */
    private $ip2;

    /**
     * @ORM\Column(type="string", length="16")
     */
    private $country;

    /**
     * Регион
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $city_id;


    /**
     * Set long_ip1
     *
     * @param bigint $longIp1
     */
    public function setLongIp1($longIp1)
    {
        $this->long_ip1 = $longIp1;
    }

    /**
     * Get long_ip1
     *
     * @return bigint 
     */
    public function getLongIp1()
    {
        return $this->long_ip1;
    }

    /**
     * Set long_ip2
     *
     * @param bigint $longIp2
     */
    public function setLongIp2($longIp2)
    {
        $this->long_ip2 = $longIp2;
    }

    /**
     * Get long_ip2
     *
     * @return bigint 
     */
    public function getLongIp2()
    {
        return $this->long_ip2;
    }

    /**
     * Set ip1
     *
     * @param string $ip1
     */
    public function setIp1($ip1)
    {
        $this->ip1 = $ip1;
    }

    /**
     * Get ip1
     *
     * @return string 
     */
    public function getIp1()
    {
        return $this->ip1;
    }

    /**
     * Set ip2
     *
     * @param string $ip2
     */
    public function setIp2($ip2)
    {
        $this->ip2 = $ip2;
    }

    /**
     * Get ip2
     *
     * @return string 
     */
    public function getIp2()
    {
        return $this->ip2;
    }

    /**
     * Set country
     *
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
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
     * Set city_id
     *
     * @param integer $cityId
     */
    public function setCityId($cityId)
    {
        $this->city_id = $cityId;
    }

    /**
     * Get city_id
     *
     * @return integer 
     */
    public function getCityId()
    {
        return $this->city_id;
    }
}