<?php
/**
 *  * User: Dawid Bednarz( dawid@bednarz.pro )
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Controller\Token;

use DawBed\ComponentBundle\Service\EventDispatcher;
use DawBed\ConfirmationBundle\Event\Token\AcceptEvent;
use DawBed\ConfirmationBundle\Event\Token\ErrorEvent;
use DawBed\ConfirmationBundle\Form\Token\TokenType;
use DawBed\ConfirmationBundle\Service\Token\AcceptService;
use DawBed\ConfirmationBundle\Validator\ValidatorGroup;
use DawBed\PHPToken\Model\AcceptModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TokenController extends AbstractController
{
    private $eventDispatcher;

    function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function accept(Request $request, AcceptService $acceptService): Response
    {
        $model = new AcceptModel();

        $form = $this->createForm(TokenType::class, $model, [
            'method' => 'POST',
            'validation_groups' => [ValidatorGroup::ACCEPT]
        ]);

        $form->submit([
            'entity' => $request->get('token')
        ]);

        if (!$form->isSubmitted() || !$form->isValid()) {
            if (!$form->getData()->hasEntity()) {
                throw new NotFoundHttpException();
            }

            return $this->eventDispatcher->dispatch(new ErrorEvent($form->getData()->getEntity(), $form), $form)
                ->getResponse();
        }

        $em = $acceptService->byModel($model);

        $response = $this->eventDispatcher->dispatch(new AcceptEvent($model->getEntity()))
            ->getResponse();

        if (is_null($response)) {
            throw new NotFoundHttpException();
        }
        $em->flush();

        return $response;
    }
}