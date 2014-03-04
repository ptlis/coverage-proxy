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

namespace ptlis\CoverageProxyBundle\Controller;

use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller used to test uploads.
 */
class TestUpload
{
    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @var TwigEngine
     */
    private $twig;


    /**
     * Constructor.
     *
     * @param FormInterface $form
     * @param TwigEngine $twig
     */
    public function __construct(FormInterface $form, TwigEngine $twig)
    {
        $this->form = $form;
        $this->twig = $twig;
    }


    /**
     * Display the upload form.
     *
     * @return Response
     */
    public function display()
    {
        return $this->twig->renderResponse(
            'ptlisCoverageProxyBundle:TestUpload:Display.html.twig',
            array(
                'form' => $this->form->createView()
            )
        );
    }
}
