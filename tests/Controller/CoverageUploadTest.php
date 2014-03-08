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

namespace ptlis\CoverageProxyBundle\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

/**
 * Functional test to verify correct processing of coverage uploads.
 */
class CoverageUploadTest extends WebTestCase
{
    private function getErrorMessage()
    {
        $message = array(
            'error' => true,
            'error_message' => '',
            'validation_errors' => array()
        );

        return json_encode($message);
    }


    public function testUploadValid()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            $client->getContainer()->get('router')->generate('upload_coverage'),
            array(
                'coverage_upload' => array(
                    'job_number' => 1,
                    'total_builds' => 1
                )
            ),
            array(
                'coverage_upload' => array(
                    'coverage' => new UploadedFile(realpath(__DIR__ . '/../data/valid.cov'), 'valid.cov')
                )
            ),
            array(
                'CONTENT_TYPE' => 'multipart/form-data'
            )
        );

        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }


    public function testUploadInvalidOmitValues()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            $client->getContainer()->get('router')->generate('upload_coverage'),
            array(),
            array(),
            array(
                'CONTENT_TYPE' => 'multipart/form-data'
            )
        );

        $this->assertEquals(
            Response::HTTP_UNSUPPORTED_MEDIA_TYPE,
            $client->getResponse()->getStatusCode()
        );

        $this->assertEquals(
            $this->getErrorMessage(),
            $client->getResponse()->getContent()
        );
    }
}
