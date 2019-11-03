<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Form;

use DawBed\ConfirmationBundle\Entity\AbstractToken;
use DawBed\ConfirmationBundle\Model\AcceptModel;
use DawBed\PHPClassProvider\ClassProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TokenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entity', EntityType::class, [
                'class' => ClassProvider::get(AbstractToken::class),
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
