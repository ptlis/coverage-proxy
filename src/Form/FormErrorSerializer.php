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

namespace ptlis\CoverageProxyBundle\Form;

use Symfony\Component\Form\FormInterface;

/**
 * Provides a convenient serialization from Symfony form errors to an array.
 */
class FormErrorSerializer
{
    /**
     * Convert the form errors to an array representation.
     *
     * @param FormInterface $form
     *
     * @return string[]|array[]
     */
    public function toArray(FormInterface $form)
    {
        $errorList = array();

        if (count($form->all())) {
            foreach ($form->all() as $child) {
                if (!$child->isValid()) {
                    $innerErrorList = $this->toArray($child);
                    if (count($innerErrorList)) {
                        $errorList[$child->getName()] = $innerErrorList;
                    }
                }
            }
        } else {
            foreach ($form->getErrors() as $error) {
                $errorList[] = $error->getMessage();
            }
        }

        return $errorList;
    }
}
