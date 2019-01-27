<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Form\Token;

use DawBed\ConfirmationBundle\Service\EntityService;
use DawBed\PHPToken\Model\AcceptModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TokenType extends AbstractType
{
    private $entityService;

    function __construct(EntityService $entityService)
    {
        $this->entityService = $entityService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entity', EntityType::class, [
                'class' => $this->entityService->Token,
                'choice_value' => 'value',
                'label' => 'token'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AcceptModel::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'Token';
    }
}
