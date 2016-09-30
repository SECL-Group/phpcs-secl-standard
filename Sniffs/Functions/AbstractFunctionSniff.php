<?php
/**
 * Function Size Test.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_Secl
 * @author    HSN <info@secl.com.ua>
 * @copyright 1994-2016 Secl Group
 * @license   https://github.com/SECL/phpcs-secl-standard/blob/master/LICENSE
 *            BSD License
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Function Parent for Test.
 *
 * Aggregate some common function.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_Secl
 * @author    HSN <info@secl.com.ua>
 * @copyright 1994-2016 Secl Group
 * @license   https://github.com/SECL/phpcs-secl-standard/blob/master/LICENSE
 *            BSD License
 * @version   Release: 1.0.0
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
abstract class Secl_Sniffs_Functions_AbstractFunctionSniff implements
    PHP_CodeSniffer_Sniff
{
    /**
     * Should this sniff check function braces?
     *
     * @var bool
     */
    public $checkFunctions = true;

    /**
     * Registers the tokens that this sniff wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_FUNCTION,
        );
    }//end register()

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return void
     */
    abstract public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr);

    /**
     * @param int   $stackPtr
     * @param array $tokens
     *
     * @return boolean
     */
    public function isValidFunctionType($stackPtr, $tokens)
    {
        if (isset($tokens[$stackPtr]['scope_opener']) === false) {
            return false;
        }

        if ($this->isFunction($stackPtr, $tokens)) {
            return false;
        }

        return true;
    }

    /**
     * @param int   $stackPtr
     * @param array $tokens
     *
     * @return bool
     */
    private function isFunction($stackPtr, $tokens)
    {
        return $tokens[$stackPtr]['code'] === T_FUNCTION
            && (bool) $this->checkFunctions === false;
    }
}//end class
