<?php

namespace Amadi\GeoBundle\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class IpRepository extends EntityRepository
{
    public function rangeIp($longIp){
        $q = $this
            ->createQueryBuilder('i')
            ->select('i')
            ->where('i.long_ip1 <= :longIp AND i.long_ip2 >= :longIp')
            ->setParameter('longIp', $longIp)
            ->getQuery();

        try {
            $city = $q->getSingleResult();
        } catch (NoResultException $q) {
            throw new NoResultException(sprintf('Unable to find an ip in database'), null, 0, $e);
        }

        return $city;
    }
}