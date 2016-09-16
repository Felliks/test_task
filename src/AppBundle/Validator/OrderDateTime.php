<?php namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class OrderDateTime
 * @Annotation
 * @package AppBundle\Validator
 */
class OrderDateTime extends Constraint
{
    /**
     * @return string
     */
    public function validatedBy()
    {
        return 'order_date_time';
    }

    /**
     * @return string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}