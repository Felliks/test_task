<?php namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;
use Knp\Component\Pager\Paginator;

/**
 * Class BaseController
 *
 * @package AppBundle\Controller
 */
abstract class BaseController
{
    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * BaseController constructor.
     * @param EngineInterface $templating
     * @param FormFactoryInterface $formFactory
     * @param RouterInterface $router
     */
    public function __construct(
        EngineInterface $templating,
        FormFactoryInterface $formFactory,
        RouterInterface $router
    )
    {
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    /**
     * @return FormFactoryInterface
     */
    public function getFormFactory()
    {
        return $this->formFactory;
    }

    /**
     * @return RouterInterface
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @return EngineInterface
     */
    public function getTemplating()
    {
        return $this->templating;
    }
}
