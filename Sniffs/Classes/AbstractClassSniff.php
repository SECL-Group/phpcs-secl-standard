<?php
/**
 * Abstract Class Test.
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
 * Abstract Class for Test.
 *
 * Aggregate some common function.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer_Secl
 * @author    HSN <info@secl.com.ua>
 * @copyright 1994-2016 Secl Group
 * @license   https://github.com/SECL/phpcs-secl-standard/blob/master/LICENSE
 *            BSD License
 * @version   Release: 1.0.1
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
abstract class Secl_Sniffs_Classes_AbstractClassSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_CLASS,
            T_INTERFACE,
            T_TRAIT,
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
     * @return bool
     */
    public function isValidClassType($stackPtr, $tokens)
    {
        if (isset($tokens[$stackPtr]['scope_opener']) === false) {
            return false;
        }

        return true;
    }

    /**
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int                  $stackPtr
     * @param array                $tokens
     *
     * @return PHP_CodeSniffer_File
     */
    protected function setParseErrorWarning($phpcsFile, $stackPtr, $tokens)
    {
        $error = 'Possible parse error: %s missing opening or closing brace';
        $data = array($tokens[$stackPtr]['content']);
        $phpcsFile->addWarning($error, $stackPtr, 'MissingBrace', $data);
    }
}//end class
