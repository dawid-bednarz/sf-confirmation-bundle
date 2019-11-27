<?php
/**
 *  * User: Dawid Bednarz( dawid@bednarz.pro )
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Controller;

use DawBed\ComponentBundle\Helper\EventResponseController;
use DawBed\ConfirmationBundle\Event\AcceptEvent;
use DawBed\ConfirmationBundle\Event\ErrorEvent;
use DawBed\ConfirmationBundle\Form\WriteType;
use DawBed\ConfirmationBundle\Model\WriteModel;
use DawBed\ConfirmationBundle\Service\WriteService;
use DawBed\ConfirmationBundle\Validator\ValidatorGroup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends AbstractController
{
    use EventResponseController;

    public function accept(Request $request, WriteService $service): Response
    {
        $model = WriteModel::consumedInstance();

        $form = $this->createForm(WriteType::class, $model, [
            'method' => Request::METHOD_POST,
            'validation_groups' => [ValidatorGroup::ACCEPT]
        ]);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            if (!$form->getData()->hasEntity()) {
                return $this->notSubmittedForm();
            }
            return $this->response(new ErrorEvent($form->getData()->getEntity(), $form));
        }
        $em = $service->make($model);

        $response = $this->response(new AcceptEvent($model->getEntity()));

        $em->flush();

        return $response;
    }
}