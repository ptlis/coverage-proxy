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

namespace ptlis\CoverageProxyBundle\API;

use ptlis\CoverageProxyBundle\Entity\Form\CoverageUpload;
use ptlis\CoverageProxyBundle\Form\FormErrorSerializer;
use Symfony\Component\Form\FormInterface;

/**
 * Process a code coverage upload.
 */
class ProcessCoverageUpload
{
    /**
     * @var FormErrorSerializer
     */
    private $errorSerializer;


    /**
     * Constructor.
     *
     * @param FormErrorSerializer $errorSerializer
     */
    public function __construct(FormErrorSerializer $errorSerializer)
    {
        $this->errorSerializer = $errorSerializer;
    }


    /**
     * Process the provided coverage upload form.
     *
     * Note: The processed file is assumed to be valid.
     *
     * @param FormInterface $form
     *
     * @return ResponsePayload
     */
    public function process(FormInterface $form)
    {
        // Push validation errors into payload
        if (!$form->isValid()) {

            $payload = new ResponsePayload();
            $payload
                ->setError(true)
                ->setValidationErrors(
                    $this->errorSerializer->toArray($form)
                );

        // Process the file upload
        } else {
            $payload = $this->processValid($form->getData());
        }

        return $payload;
    }


    private function processValid(CoverageUpload $coverageUpload)
    {
        $payload = new ResponsePayload();

        return $payload;
    }
}
