<?php

namespace Amadi\GeoBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Session;
use Doctrine\ORM\EntityManager;


/**
 * GeocodeBundle.
 * Created by amadi.
 */
class Geo
{
    /**
     * @var EntityManager
     */
    protected $em;
    /**
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    protected $securityContext;
    /**
     * @var \Symfony\Component\HttpFoundation\Request $request
     */
    protected $request;
    /**
     * @var string IP-address
     */
    protected $ip;

    public function __construct(EntityManager $entityManager, SecurityContext $securityContext)
    {
        $this->em = $entityManager;
        $this->securityContext = $securityContext;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return Geo
     */
    public function init(Request $request){
        $this->request = $request;
        $this->ip = $this->request->getClientIp();
        return $this;
    }

    /**
     * @return array ("region" -> Строка, "location" -> Число)
     */
    public function locate(){
        //Сначала проверяем куки
        if ($this->request->cookies->has('region')){
            $this->putsToSession($this->request->cookies->get('location'),$this->request->cookies->get('region'));
        } else {
            // Если у пользователя уже есть сессия с определённым регионом,
            // то при вызове метода он вернёт массив с информацией по текущему региону
            if ( ! $this->request->getSession()->has('region')){

                $location = $this->findInRange();

                // Для зарегистрированного пользователя пытаемся достать значение региона из бд
                // для остальных ищем регион по базе и устанавливаем сессию и куки.
                if ( ! $this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
                    //записываем в куки и сессии значение
                    $this->puts($location->getCityId()->getRegion());
                    //возвращаем на всякий пожарный выбранный регион
                    return $location->getCityId()->getRegion()->getId();
                } else {
                    //Получаем текущего пользователя
                    $user = $this->securityContext->getToken()->getUser();
                    //если у пользователя не указан регион в профиле, то определяем текущее местоположение.
                    if ($user->region != null){
                        $this->puts($user->region);
                    } else {
                        //записываем в куки значение
                        $this->puts($location->getCityId()->getRegion());
                        //возвращаем на всякий пожарный выбранный регион
                        return $location->getCityId()->getRegion()->getId();
                    }
                }
            } else {
                return array(
                    'region' => $this->request->getSession()->get('region'),
                    'location' => $this->request->getSession()->get('location')
                );

            }
        }
    }
    /**
     * Ищет диапазон IP, в который входит текущий адресс пользователя.
     * @param bool $unknown - если true - тогда аозвращаем Москву
     * @return GeoBundle:Ip Object
     */
    private function findInRange(){
        $city = $this->em->getRepository('AmadiGeoBundle:Ip')->rangeIp(ip2long($this->ip));
        if ($city == null){
            $city = $this->em->getRepository('AmadiGeoBundle:Ip')->findOneByCity_Id('2097'); //Москва, деточка... Москва...
        }
        return $city;
    }

    /**
     * Записывает в куки код региона. Код по базе а не по нумерации РФ
     * @param $location Объёкт GeoBundle:Region
     */
     public function puts($location){
        //Создание новых кук.
        $code = new Cookie('location', $location->getId(), (time() + 3600 * 24 * 7), '/', $this->request->getHost(), false, false);
        $region = new Cookie('region', $location->getRegion(), (time() + 3600 * 24 * 7), '/', $this->request->getHost(), false, false);


        $this->putsToSession($location->getId(), $location->getRegion());
        //Установка заголовка и его отправка
        $response = new Response();
        $response->setCharset('utf-8');
        $response->headers->setCookie($code);
        $response->headers->setCookie($region);
        $response->send();
    }

    /**
     * @param $location
     * @param $region
     */
    private function putsToSession($location, $region){
        ///получение текущих сессий
        $session = $this->request->getSession();
        $session->start();

        //установка новых сессий
        $session->set('location', $location);
        $session->set('region', $region);
        return;
    }
}
