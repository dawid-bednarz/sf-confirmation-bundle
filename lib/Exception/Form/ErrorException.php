<?php
/**
 *  * Created by PhpStorm.
 * User: Dawid Bednarz( dawid@bednarz.pl )
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Exception\Form;

use DawBed\ComponentBundle\Exception\Form\BaseException;
use DawBed\ConfirmationBundle\Exception\ConfirmationBundleException;

class ErrorException extends BaseException implements ConfirmationBundleException
{

}