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

namespace ptlis\CoverageProxyBundle\Controller;

use JMS\Serializer\Serializer;
use ptlis\CoverageProxyBundle\API\ResponsePayload;
use ptlis\CoverageProxyBundle\Form\FormErrorSerializer;
use ptlis\CoverageProxyBundle\Http\ApiResponse;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller for processing coverage uploads.
 */
class CoverageUpload
{
    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @var FormErrorSerializer
     */
    private $errorSerializer;

    /**
     * JMS Serializer.
     *
     * @var Serializer
     */
    private $serializer;


    /**
     * Constructor.
     *
     * @param FormInterface $form
     * @param FormErrorSerializer $errorSerializer
     * @param Serializer $serializer
     */
    public function __construct(FormInterface $form, FormErrorSerializer $errorSerializer, Serializer $serializer)
    {
        $this->form = $form;
        $this->errorSerializer = $errorSerializer;
        $this->serializer = $serializer;
    }


    /**
     * Process the submission.
     *
     * @param Request $request
     *
     * @return ApiResponse
     */
    public function submit(Request $request)
    {
        $this->form->handleRequest($request);

        $payload = new ResponsePayload();

        if (!$this->form->isValid()) {
            $payload
                ->setError(true)
                ->setValidationErrors(
                    $this->errorSerializer->toArray($this->form)
                );
        }

        return new ApiResponse(
            $this->serializer->serialize($payload, 'json')
        );
    }
}
