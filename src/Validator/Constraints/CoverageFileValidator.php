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

use PHP_CodeCoverage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validator to ensure that an uploaded coverage file is valid.
 */
class CoverageFileValidator extends ConstraintValidator
{
    /**
     * @var bool
     */
    private $error = false;


    /**
     * Validation function to ensure that the coverage file is valid.
     *
     * @param UploadedFile  $coverageFile
     * @param Constraint    $constraint
     */
    public function validate($coverageFile, Constraint $constraint)
    {
        // TODO: Files that emit output (echo, others?)
        // TODO: Closing php?
        // TODO: Class definitions?
        // TODO: Anything else to make safe??

        $this
            ->validFileType($coverageFile, $constraint)
            ->lintFile($coverageFile, $constraint)
            ->validateFunctionCalls($coverageFile, $constraint)
            ->validateClassInstances($coverageFile, $constraint);

        // Attempt to load the file
        if (!$this->error) {
            ob_start();
            $coverage = include($coverageFile->getFileInfo()->getPathname());
            ob_end_clean();
            if (!($coverage instanceof PHP_CodeCoverage)) {
                $this->emitError($constraint);
            }
        }
    }


    /**
     * @param Constraint $constraint
     */
    public function emitError(Constraint $constraint)
    {
        $this->error = true;
        $this->context->addViolation($constraint->message);
    }


    /**
     * Ensure that the upload file is a PHP file.
     *
     * @param UploadedFile $coverageFile
     * @param Constraint   $constraint
     *
     * @return CoverageFileValidator
     */
    private function validFileType(UploadedFile $coverageFile, Constraint $constraint)
    {
        if (!$this->error) {
            $fInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($fInfo, $coverageFile->getFileInfo()->getPathname());

            if ($mime !== 'text/x-php') {
                $this->emitError($constraint);
            }
        }

        return $this;
    }


    /**
     * Lint the provided file & ensure there are no errors.
     *
     * @param UploadedFile $coverageFile
     * @param Constraint   $constraint
     *
     * @return CoverageFileValidator
     */
    private function lintFile(UploadedFile $coverageFile, Constraint $constraint)
    {
        if (!$this->error) {
            $result = exec('php -l ' . escapeshellarg($coverageFile->getFileInfo()->getPathname()));

            if (preg_match('/^Errors parsing/i', $result, $match)) {
                $this->emitError($constraint);
            }
        }

        return $this;
    }


    /**
     * Restrict allowed function calls.
     *
     * @param UploadedFile $coverageFile
     * @param Constraint   $constraint
     *
     * @return CoverageFileValidator
     */
    private function validateFunctionCalls(UploadedFile $coverageFile, Constraint $constraint)
    {
        if (!$this->error) {
            $fileData = file_get_contents($coverageFile->getFileInfo()->getPathname());
            $regex = '/(.*?(\-\>)?)\s*([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*\(.*\)\s*;/';

            if (preg_match_all($regex, $fileData, $matchList)) {

                foreach ($matchList[3] as $key => $match) {

                    if ($match !== 'filter' || $matchList[2][$key] !== '->') {
                        $this->emitError($constraint);
                        break;
                    }
                }
            }
        }

        return $this;
    }


    /**
     * Restrict allowed class instances.
     *
     * @param UploadedFile $coverageFile
     * @param Constraint   $constraint
     *
     * @return CoverageFileValidator
     */
    private function validateClassInstances(UploadedFile $coverageFile, Constraint $constraint)
    {
        if (!$this->error) {
            $fileData = file_get_contents($coverageFile->getFileInfo()->getPathname());
            $regex = '/new\s*(\$?[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)/';

            if (preg_match_all($regex, $fileData, $matchList)) {

                foreach ($matchList[1] as $match) {

                    if ($match !== 'PHP_CodeCoverage') {
                        $this->emitError($constraint);
                        break;
                    }
                }
            }
        }

        return $this;
    }
}
