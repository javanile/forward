<?php
/**
 * Short description for class.
 *
 * @author    Francesco Bianco <bianco@javanile.org>
 * @copyright 2019 Javanile
 * @license   https://github.com/javanile/forward/blob/master/LICENSE  MIT License
 *
 * @version   Release: 0.0.1
 *
 * @link      https://github.com/javanile/forward
 */
require_once '../vendor/autoload.php';

use Javanile\Forward\Forward;

$forward = new Forward([
    'config'  => require_once '../config.php',
    'headers' => getallheaders(),
    'server'  => $_SERVER,
    'files'   => $_FILES,
    'post'    => $_POST,
]);

try {
    if ($forward->process()) {
        if ($forward->getEmail()->send()) {
            echo $forward->successResponse();
        } else {
            echo $forward->problemResponse();
        }
    } else {
        echo $forward->processErrorResponse();
    }
} catch (Exception $exception) {
    echo $forward->exceptionResponse($exception);
}
