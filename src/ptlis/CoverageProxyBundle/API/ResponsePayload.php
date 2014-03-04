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

/**
 * Entity representing a JSON envelope and payload.
 */
class ResponsePayload
{
    /**
     * @var bool
     */
    private $error = false;

    /**
     * @var string
     */
    private $error_message = '';

    /**
     * @var string[][]
     */
    private $validation_errors = array();

    /**
     * @var mixed
     */
    private $body;


    /**
     * @param boolean $error
     *
     * @return ResponsePayload
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }


    /**
     * @return boolean
     */
    public function getError()
    {
        return $this->error;
    }


    /**
     * @param string $error_message
     *
     * @return ResponsePayload
     */
    public function setErrorMessage($error_message)
    {
        $this->error_message = $error_message;

        return $this;
    }


    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->error_message;
    }


    /**
     * @param mixed $body
     *
     * @return ResponsePayload
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }


    /**
     * @param string[] $validation_errors
     *
     * @return ResponsePayload
     */
    public function setValidationErrors($validation_errors)
    {
        $this->validation_errors = $validation_errors;

        return $this;
    }


    /**
     * @return string[]
     */
    public function getValidationErrors()
    {
        return $this->validation_errors;
    }
}
