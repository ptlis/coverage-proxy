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
use ptlis\CoverageProxyBundle\API\ProcessCoverageUpload;
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
     * @var ProcessCoverageUpload
     */
    private $processCoverageUpload;

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
     * @param ProcessCoverageUpload $processCoverageUpload
     * @param Serializer $serializer
     */
    public function __construct(FormInterface $form, ProcessCoverageUpload $processCoverageUpload, Serializer $serializer)
    {
        $this->form = $form;
        $this->processCoverageUpload = $processCoverageUpload;
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

        $payload = $this->processCoverageUpload->process($this->form);

        // TODO: Basic factory to convert payload into response.

        return new ApiResponse(
            $this->serializer->serialize($payload, 'json')
        );
    }
}
