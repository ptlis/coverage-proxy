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

namespace ptlis\CoverageProxyBundle\Entity\Form;

/**
 * Entity used for processing coverage upload form.
 */
class CoverageUpload
{
    /**
     * @var string
     */
    private $coverage;

    /**
     * @var string
     */
    private $job_number;

    /**
     * @var int
     */
    private $total_builds;


    /**
     * @param string $coverage
     *
     * @return CoverageUpload
     */
    public function setCoverage($coverage)
    {
        $this->coverage = $coverage;

        return $this;
    }


    /**
     * @return string
     */
    public function getCoverage()
    {
        return $this->coverage;
    }


    /**
     * @param string $job_number
     *
     * @return CoverageUpload
     */
    public function setJobNumber($job_number)
    {
        $this->job_number = $job_number;

        return $this;
    }


    /**
     * @return string
     */
    public function getJobNumber()
    {
        return $this->job_number;
    }


    /**
     * @param int $total_builds
     *
     * @return CoverageUpload
     */
    public function setTotalBuilds($total_builds)
    {
        $this->total_builds = $total_builds;

        return $this;
    }


    /**
     * @return int
     */
    public function getTotalBuilds()
    {
        return $this->total_builds;
    }
}
