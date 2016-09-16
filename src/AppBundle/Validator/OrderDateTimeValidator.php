<?php namespace AppBundle\Validator;

use AppBundle\Entity\Orders;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;

/**
 * Class OrderDateTimeValidator
 * @package AppBundle\Validator
 */
class OrderDateTimeValidator extends ConstraintValidator
{
    /**
     * @var array
     */
    private $allowedTimes;

    /**
     * @var array
     */
    private $allowedDays;

    /**
     * OrderDateTimeValidator constructor.
     * @param array $allowedDays
     * @param array $allowedTimes
     */
    public function __construct(array $allowedDays, array $allowedTimes)
    {
        $this->allowedTimes = $allowedTimes;
        $this->allowedDays = $allowedDays;
    }

    /**
     * @param Orders $object
     * @param Constraint $constraint
     */
    public function validate($object, Constraint $constraint)
    {
        $dayOfWeek = $object->getDatetime()->format('N');
        $time = $object->getDatetime()->format('H:i');

        if (!in_array($dayOfWeek, $this->allowedDays)) {
            $this->context->addViolation('Selected date is not valid');
        }

        if (!in_array($time, $this->allowedTimes)) {
            $this->context->addViolation('Selected time is not valid');
        }
    }
}