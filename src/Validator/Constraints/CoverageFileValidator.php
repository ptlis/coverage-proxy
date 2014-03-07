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
     * Validation function to ensure that the coverage file is valid.
     *
     * @param UploadedFile  $coverageFile
     * @param Constraint    $constraint
     */
    public function validate($coverageFile, Constraint $constraint)
    {
        $error = false;

        // Ensure valid type
        if (!$error) {
            $fInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($fInfo, $coverageFile->getFileInfo()->getPathname());
            if (!$error && $mime !== 'text/x-php') {
                $this->emitError($constraint);
                $error = true;
            }
        }

        // Lint the file
        if (!$error) {
            $result = exec('php -l ' . escapeshellarg($coverageFile->getFileInfo()->getPathname()));

            if (preg_match('/^Errors parsing/i', $result, $match)) {
                $this->context->addViolation('bad times! (lint)');
                $error = true;
            }
        }

        // Files that emit output (echo, others?)
        // TODO: Anything else to make safe??
        // TODO: Closing php?

        if (!$error) {
            $fileData = file_get_contents($coverageFile->getFileInfo()->getPathname());

            // Validate function calls
            if (!$error && preg_match_all('/\s*(.*?(\-\>)?)\s*([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*\(.*\)\s*;/', $fileData, $matchList)) {
                foreach ($matchList[3] as $key => $match) {
                    if ($match !== 'filter' || $matchList[2][$key] !== '->') {
                        $this->context->addViolation('bad times! (func)');
                        $error = true;
                    }
                }
            }

            // Validate 'new' uses
            if (!$error && preg_match_all('/new\s*\$?([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)/', $fileData, $matchList)) {
                foreach ($matchList[1] as $match) {
                    if ($match !== 'PHP_CodeCoverage') {
                        $this->context->addViolation('bad times (class)!');
                        $error = true;
                    }
                }
            }
        }



        // Attempt to load the file
        if (!$error) {
            ob_start();
            $coverage = include($coverageFile->getFileInfo()->getPathname());
            ob_end_clean();
            if (!$error && !($coverage instanceof PHP_CodeCoverage)) {
                $this->emitError($constraint);
                $error = true;
            }
        }
    }


    /**
     * @param Constraint $constraint
     */
    public function emitError(Constraint $constraint)
    {
        $this->context->addViolation($constraint->message);
    }
}
