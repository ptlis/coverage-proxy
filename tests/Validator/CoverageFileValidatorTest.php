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

namespace ptlis\CoverageProxyBundle\Test\Validator;

use ptlis\CoverageProxyBundle\Entity\Form\CoverageUpload;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Validator;

require_once __DIR__.'/../../app/AppKernel.php';

/**
 * Functional test to verify correctness of coverage file validator.
 */
class CoverageFileValidatorTest extends WebTestCase
{
    /**
     * @return Validator
     */
    private function getValidator()
    {
        $kernel = new \AppKernel('dev', true);
        $kernel->boot();

        return $kernel->getContainer()->get('validator');
    }


    public function testEvilPhp1()
    {
        $this->runTestEvilPhp(realpath(__DIR__ . '/../data/evil1.cov'), 'evil1.cov');
    }


    public function testEvilPhp2()
    {
        $this->runTestEvilPhp(realpath(__DIR__ . '/../data/evil2.cov'), 'evil2.cov');
    }


    public function testEvilPhp3()
    {
        $this->runTestEvilPhp(realpath(__DIR__ . '/../data/evil3.cov'), 'evil3.cov');
    }


    public function testEvilPhp4()
    {
        $this->runTestEvilPhp(realpath(__DIR__ . '/../data/evil4.cov'), 'evil4.cov');
    }


    public function testEvilPhp5()
    {
        $this->runTestEvilPhp(realpath(__DIR__ . '/../data/evil5.cov'), 'evil5.cov');
    }


    public function testEvilPhp6()
    {
        $this->runTestEvilPhp(realpath(__DIR__ . '/../data/evil6.cov'), 'evil6.cov');
    }


    public function testEvilPhp7()
    {
        $this->runTestEvilPhp(realpath(__DIR__ . '/../data/evil7.cov'), 'evil7.cov');
    }


    public function testEmpty1()
    {
        $this->runTestEvilPhp(realpath(__DIR__ . '/../data/empty1.cov'), 'empty1.cov');
    }


    public function testEmpty2()
    {
        $this->runTestEvilPhp(realpath(__DIR__ . '/../data/empty2.cov'), 'empty2.cov');
    }


    private function runTestEvilPhp($path, $filename)
    {
        $uploadFile = new UploadedFile($path, $filename);

        $coverageUpload = new CoverageUpload();
        $coverageUpload
            ->setJobNumber(1)
            ->setTotalBuilds(5)
            ->setCoverage($uploadFile);

        $validator = $this->getValidator();
        $errorList = $validator->validate($coverageUpload);

        $this->assertEquals(
            1,
            count($errorList)
        );

        $this->assertEquals(
            'The provided coverage report is not valid.',
            $errorList[0]->getMessage()
        );
    }
}
