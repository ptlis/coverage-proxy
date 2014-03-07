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
    public function testEvilPhp1()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            $client->getContainer()->get('router')->generate('upload_coverage'),
            array(),
            array(
                new UploadedFile(realpath(__DIR__ . '/data/evil1.cov'), 'evil1.cov')
            )
        );

        $this->assertEquals(
            Response::HTTP_UNSUPPORTED_MEDIA_TYPE,
            $client->getResponse()->getStatusCode()
        );
    }


    public function testEvilPhp2()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            $client->getContainer()->get('router')->generate('upload_coverage'),
            array(),
            array(
                new UploadedFile(realpath(__DIR__ . '/data/evil2.cov'), 'evil2.cov')
            )
        );

        $this->assertEquals(
            Response::HTTP_UNSUPPORTED_MEDIA_TYPE,
            $client->getResponse()->getStatusCode()
        );
    }


    public function testEvilPhp3()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            $client->getContainer()->get('router')->generate('upload_coverage'),
            array(),
            array(
                new UploadedFile(realpath(__DIR__ . '/data/evil3.cov'), 'evil3.cov')
            )
        );

        $this->assertEquals(
            Response::HTTP_UNSUPPORTED_MEDIA_TYPE,
            $client->getResponse()->getStatusCode()
        );
    }


    public function testEvilPhp4()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            $client->getContainer()->get('router')->generate('upload_coverage'),
            array(),
            array(
                new UploadedFile(realpath(__DIR__ . '/data/evil4.cov'), 'evil4.cov')
            )
        );

        $this->assertEquals(
            Response::HTTP_UNSUPPORTED_MEDIA_TYPE,
            $client->getResponse()->getStatusCode()
        );
    }


    public function testEvilPhp5()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            $client->getContainer()->get('router')->generate('upload_coverage'),
            array(),
            array(
                new UploadedFile(realpath(__DIR__ . '/data/evil5.cov'), 'evil5.cov')
            )
        );

        $this->assertEquals(
            Response::HTTP_UNSUPPORTED_MEDIA_TYPE,
            $client->getResponse()->getStatusCode()
        );
    }


    public function testEvilPhp6()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            $client->getContainer()->get('router')->generate('upload_coverage'),
            array(),
            array(
                new UploadedFile(realpath(__DIR__ . '/data/evil6.cov'), 'evil6.cov')
            )
        );

        $this->assertEquals(
            Response::HTTP_UNSUPPORTED_MEDIA_TYPE,
            $client->getResponse()->getStatusCode()
        );
    }


    public function testEvilPhp7()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            $client->getContainer()->get('router')->generate('upload_coverage'),
            array(),
            array(
                new UploadedFile(realpath(__DIR__ . '/data/evil7.cov'), 'evil7.cov')
            )
        );

        $this->assertEquals(
            Response::HTTP_UNSUPPORTED_MEDIA_TYPE,
            $client->getResponse()->getStatusCode()
        );
    }
}
