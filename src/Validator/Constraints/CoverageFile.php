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

namespace ptlis\CoverageProxyBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Constraint to ensure that an uploaded coverage file is valid.
 */
class CoverageFile extends Constraint
{
    /**
     * @var string
     */
    public $message = 'The provided coverage report is not valid.';


    /**
     * @return string
     */
    public function validateBy()
    {
        return 'coverage_file';
    }
}
