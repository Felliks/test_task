<?php namespace AppBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Orders;

/**
 * Class OrdersManager
 * @package AppBundle\Manager
 */
class OrdersManager
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var array
     */
    private $allowedTimes = [];

    /**
     * @var array
     */
    private $allowedWeekDays = [];

    /**
     * OrdersManager constructor.
     * @param ObjectManager $objectManager
     */
    public function __construct(
        ObjectManager $objectManager
    ) {
        $this->objectManager = $objectManager;
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->objectManager
            ->getRepository('AppBundle:Orders')
            ->findAll();
    }

    /**
     * @param Orders $order
     */
    public function delete(Orders $order)
    {
        $this->objectManager->remove($order);
        $this->objectManager->flush();
    }

    /**
     * @param Orders $order
     */
    public function save(Orders $order)
    {
        $this->objectManager->persist($order);
        $this->objectManager->flush();
    }

    /**
     * @return array
     */
    public function getAllowedTimes()
    {
        return $this->allowedTimes;
    }

    /**
     * @param array $allowedTimes
     */
    public function setAllowedTimes(array $allowedTimes)
    {
        $this->allowedTimes = $allowedTimes;
    }

    /**
     * @return array
     */
    public function getAllowedWeekDays()
    {
        return $this->allowedWeekDays;
    }

    /**
     * @param array $allowedWeekDays
     */
    public function setAllowedWeekDays(array $allowedWeekDays)
    {
        $this->allowedWeekDays = $allowedWeekDays;
    }
}