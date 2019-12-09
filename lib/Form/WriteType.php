<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Form;

use DawBed\ConfirmationBundle\Entity\AbstractToken;
use DawBed\ConfirmationBundle\Model\WriteModel;
use DawBed\PHPClassProvider\ClassProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Valid;

class WriteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', EntityType::class, [
                'attr' => 'entity',
                'class' => ClassProvider::get(AbstractToken::class),
                'choice_value' => 'value',
                'label' => 'token',
                'constraints' => [
                    new Valid()
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WriteModel::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'Token';
    }
}
