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

namespace ptlis\CoverageProxyBundle\Test\Form;

use ptlis\CoverageProxyBundle\Form\FormErrorSerializer;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Functional test to verify correctness of coverage upload type.
 */
class CoverageUploadTypeTest extends WebTestCase
{
    /**
     * @return FormInterface
     */
    private function getForm()
    {
        $kernel = new \AppKernel('dev', true);
        $kernel->boot();

        return $kernel->getContainer()->get('form.coverage_upload');
    }


    public function testError()
    {
        $form = $this->getForm();

        $form->handleRequest(new Request());

        $errorMessage = 'The provided coverage report is not valid.';
        $form->get('job_number')->addError(new FormError($errorMessage, $errorMessage));

        $errorSerializer = new FormErrorSerializer();
        $errorList = $errorSerializer->toArray($form);

        $this->assertEquals(
            1,
            count($errorList)
        );

        $this->assertEquals(
            array(
                'The provided coverage report is not valid.'
            ),
            $errorList['job_number']
        );
    }
}
