<?php namespace AppBundle\Controller;

use AppBundle\Manager\OrdersManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Entity\Orders;
use AppBundle\Form\OrdersType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class OrdersController
 * @package AppBundle\Controller
 */
class OrdersController extends BaseController
{
    /**
     * @var Form
     */
    private $form;

    /**
     * @var OrdersManager
     */
    private $ordersManager;

    /**
     * @return OrdersManager
     */
    public function getOrdersManager()
    {
        return $this->ordersManager;
    }

    /**
     * @param OrdersManager $ordersManager
     */
    public function setOrdersManager(OrdersManager $ordersManager)
    {
        $this->ordersManager = $ordersManager;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $entities = $this->getOrdersManager()->getList();

        return $this->getTemplating()->renderResponse('@App/Orders/index.html.twig', [
            'entities' => $entities,
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $this->createNewOrdersForm();
        $this->form->handleRequest($request);

        return $this->getTemplating()->renderResponse('@App/Orders/new.html.twig', [
            'form' => $this->form->createView(),
            'allowedTimes' => $this->getOrdersManager()->getAllowedTimes(),
        ]);
    }

    /**
     * @ParamConverter("order", class="AppBundle:Orders")
     * @param Orders $order
     * @return array
     */
    public function editAction(Orders $order)
    {
        $this->createEditOrdersForm($order);
        $deleteForm = $this->createDeleteForm($order);

        return $this->getTemplating()->renderResponse('@App/Orders/edit.html.twig', [
            'entity' => $order,
            'edit_form' => $this->form->createView(),
            'delete_form' => $deleteForm->createView(),
            'allowedTimes' => $this->getOrdersManager()->getAllowedTimes(),
        ]);
    }

    /**
     * @ParamConverter("order", class="AppBundle:Orders")
     * @param Orders $order
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Orders $order)
    {
        $deleteForm = $this->createDeleteForm($order);

        return $this->getTemplating()->renderResponse('@App/Orders/show.html.twig', [
            'entity' => $order,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * @ParamConverter("order", class="AppBundle:Orders")
     * @param Request $request
     * @param Orders $order
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, Orders $order)
    {
        $deleteForm = $this->createDeleteForm($order);
        $this->createEditOrdersForm($order);
        $this->form->handleRequest($request);

        if ($this->form->isValid()) {
            $this->getOrdersManager()->save($order);
            return new RedirectResponse(
                $this->getRouter()->generate('orders.show', ['id' => $order->getId()])
            );
        }

        return $this->getTemplating()->renderResponse('@App/Orders/edit.html.twig', [
            'entity' => $order,
            'edit_form' => $this->form->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $Orders = new Orders();
        $this->createNewOrdersForm($Orders);
        $this->form->handleRequest($request);

        if ($this->form->isValid()) {
            $this->ordersManager->save($Orders);
            return new RedirectResponse(
                $this->getRouter()->generate('orders.show', ['id' => $Orders->getId()])
            );
        }

        return $this->getTemplating()->renderResponse('@App/Orders/new.html.twig', [
            'entity' => $Orders,
            'form' => $this->form->createView(),
            'allowedTimes' => $this->getOrdersManager()->getAllowedTimes(),
        ]);
    }

    /**
     * @ParamConverter("order", class="AppBundle:Orders")
     * @param Request $request
     * @param Orders $order
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Orders $order)
    {
        $form = $this->createDeleteForm($order);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getOrdersManager()->delete($order);
        }

        return new RedirectResponse(
            $this->getRouter()->generate('orders.list')
        );
    }

    /**
     * @return JsonResponse
     */
    public function getAllowedDateTimeAction()
    {
        return new JsonResponse([
            'allowedTimes' => $this->getOrdersManager()->getAllowedTimes(),
            'allowedWeekDays' => $this->getOrdersManager()->getAllowedWeekDays(),
        ]);
    }

    /**
     * @param Orders|null $Order
     */
    private function createNewOrdersForm(Orders $Order = null)
    {
        $this->form = $this->getFormFactory()->create(OrdersType::class, $Order, [
            'action' => $this->getRouter()->generate('orders.create'),
        ]);

        $this->form->add('submit', SubmitType::class, [
            'label' => 'Create'
        ]);
    }

    /**
     * @param Orders $order
     */
    private function createEditOrdersForm(Orders $order)
    {
        $this->form = $this->getFormFactory()->create(OrdersType::class, $order, [
            'action' => $this->getRouter()->generate('orders.update', ['id' => $order->getId()]),
        ]);

        $this->form->add('submit', SubmitType::class, [
            'label' => 'Save'
        ]);
    }

    /**
     * @param Orders $order
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Orders $order)
    {
        $form = $this->getFormFactory()->create(FormType::class, null, [
            'action' => $this->getRouter()->generate('orders.delete', ['id' => $order->getId()]),
            'method' => 'DELETE',
        ]);

        $form->add('submit', SubmitType::class, [
            'label' => 'Delete'
        ]);

        return $form;
    }
}