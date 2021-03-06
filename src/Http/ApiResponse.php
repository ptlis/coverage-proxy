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

namespace ptlis\CoverageProxyBundle\Http;

use Symfony\Component\HttpFoundation\Response;

/**
 * Custom response type taking a JSON payload provided as a string.
 */
class ApiResponse extends Response
{
    /**
     * {@inheritDoc}
     */
    public function __construct($content = '', $status = 200, $headers = array())
    {
        parent::__construct($content, $status, $headers);

        $this->headers->set('Content-Type', 'application/json');
    }
}
