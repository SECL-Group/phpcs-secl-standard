<?php
/**
 * This file is part of the Secl-coding-standard (phpcs standard)
 *
 * PHP version 5
 *
 * @category PHP
 * @package  PHP_CodeSniffer_Secl
 * @author   HSN <info@secl.com.ua>
 * @license  https://github.com/SECL/phpcs-secl-standard/blob/master/LICENSE BSD License
 * @version  GIT: master
 * @link     https://github.com/SECL/phpcs-secl-standard
 */

/**
 * Unit test class for the Function Complexity sniff.
 *
 * A sniff unit test checks a .inc file for expected violations of a single
 * coding standard. Expected errors and warnings are stored in this class.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_Secl
 * @author    HSN <info@secl.com.ua>
 * @copyright 1994-2016 Secl Group
 * @license   https://github.com/SECL/phpcs-secl-standard/blob/master/LICENSE
 *            BSD License
 * @link      https://github.com/SECL/phpcs-secl-standard
 */
class Secl_Tests_Functions_CyclomaticComplexityUnitTest extends AbstractSniffUnitTest
{
    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @return array(int => int)
     */
    public function getErrorList()
    {
        return array(
            21 => 1,
        );

    }

    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of warnings that should occur on that line.
     *
     * @return array(int => int)
     */
    public function getWarningList()
    {
        return array();

    }
}
