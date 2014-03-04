<?php

/**
 * PHP Version 5.3
 *
 * @copyright   (c) 2014 brian ridley
 * @author      brian ridley <ptlis@ptlis.net>
 * @license     http://opensource.org/licenses/MIT MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ptlis\CoverageProxyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form for upload of coverage.
 */
class CoverageUploadType extends AbstractType
{
    /**
     * Build the form.
     *
     * @param FormBuilderInterface $builder FormBuilder.
     * @param array                $options Options.
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'coverage',
                'file'
            )
            ->add(
                'job_number',
                'text'
            )
            ->add(
                'total_builds',
                'text'
            )
            ->add(
                'upload',
                'submit'
            );
    }


    /**
     * Disable CSRF protection for API.
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults([
            'data_class' => 'ptlis\CoverageProxyBundle\Entity\Form\CoverageUpload',
            'csrf_protection' => false
        ]);
    }


    /**
     * @return string   The form type.
     */
    public function getParent()
    {
        return 'form';
    }


    /**
     * @return string   Unique name.
     */
    public function getName()
    {
        return 'coverage_upload';
    }
}
