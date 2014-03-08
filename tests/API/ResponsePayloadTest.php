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

namespace ptlis\CoverageProxyBundle\Test\API;


use ptlis\CoverageProxyBundle\API\ResponsePayload;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResponsePayloadTest extends WebTestCase
{
    public function testPayloadError()
    {
        $payload = new ResponsePayload();

        $payload
            ->setError(true);

        $this->assertEquals(
            true,
            $payload->getError()
        );
    }


    public function testPayloadErrorMessage()
    {
        $payload = new ResponsePayload();

        $payload
            ->setErrorMessage('Oh no!')
            ->setValidationErrors(array())
            ->setBody(array());

        $this->assertEquals(
            'Oh no!',
            $payload->getErrorMessage()
        );
    }


    public function testPayloadValidationErrors()
    {
        $payload = new ResponsePayload();

        $payload
            ->setValidationErrors(array(
                'foo' => 'bar'
            ));

        $this->assertEquals(
            array('foo' => 'bar'),
            $payload->getValidationErrors()
        );
    }


    public function testPayloadBody()
    {
        $payload = new ResponsePayload();

        $payload
            ->setBody(array(
                'id' => 1
            ));

        $this->assertEquals(
            array('id' => 1),
            $payload->getBody()
        );
    }
}
