<?php
/**
 * Class Size Test.
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
 * Class Size Test.
 *
 * Checks maximum function number of the class.
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
class Secl_Sniffs_Classes_ClassSizeSniff extends Secl_Sniffs_Classes_AbstractClassSniff
{
    /**
     * Maximum lines number of the function
     */
    const CLASS_MAX_FUNCTION_NUMBER = 15;

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (!$this->isValidClassType($stackPtr, $tokens)) {
            $this->setParseErrorWarning($phpcsFile, $stackPtr, $tokens);

            return;
        }

        $functionsCount = $this->countNeedles($stackPtr, $tokens);

        if ($functionsCount > self::CLASS_MAX_FUNCTION_NUMBER) {
            $errorMessage = 'The number of functions in the %s class must not be more than %d!';
            $errorType = 'ClassSize';
            $className = $phpcsFile->getDeclarationName($stackPtr);
            $errorData = [$className, self::CLASS_MAX_FUNCTION_NUMBER];
            $phpcsFile->addError($errorMessage, $stackPtr, $errorType, $errorData);
        }
    }

    /**
     * @param int $stackPtr
     * @param array $tokens
     *
     * @return int
     */
    private function countNeedles($stackPtr, $tokens)
    {
        $openingBrace = $tokens[$stackPtr]['scope_opener'];
        $closingBrace = $tokens[$stackPtr]['scope_closer'];

        $functionsCount = 0;

        for ($i = $openingBrace + 1; $i < $closingBrace - 1; $i++) {
            if ('T_FUNCTION' === $tokens[$i]['type']) {
                $functionsCount++;
            }
        }

        return $functionsCount;
    }
}//end class
