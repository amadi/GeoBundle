<?php

namespace Amadi\GeoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Session;
use Doctrine\ORM\EntityManager;


class GeoController extends Controller
{
    /**
     * @return mixed
     */
    public function showRegionAction(){
        if ($this->container->get('request')->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getEntityManager();
            $regions = $em->getRepository('AmadiGeoBundle:Region')->findAll();
            $districts = $em->getRepository('AmadiGeoBundle:District')->findByCountryId('2');
            return $this->render('AmadiGeoBundle::region.html.twig', array(
                    'regions'      => $regions,
                    'districts'      => $districts,
                )
            );
        }
    }

    /**
     * @param $code
     * @return mixed
     * @todo В редиректе укажите роут страницы, на которую нужно направлять пользователя после выбора региона
     */
    public function selectRegionAction($code){
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();
        $regions = $em->getRepository('AmadiGeoBundle:Region')->findOneById($code);
        $geo = $this->container->get('geo')->init($request)->puts($regions);
        return $this->redirect($this->generateUrl('_index_page'));
    }
}
