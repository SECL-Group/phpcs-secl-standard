<?php
/**
 * Arguments Number Limit Test.
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
 * Arguments Number Limit Test.
 *
 * Checks maximum arguments number of the function.
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
class Secl_Sniffs_Functions_ArgumentsNumberLimitSniff extends
    Secl_Sniffs_Functions_AbstractFunctionSniff
{
    /**
     * Maximum arguments number of the function
     */
    const ARGUMENTS_NUMBER_LIMIT = 4;

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

        if (!$this->isValidFunctionType($stackPtr, $tokens)) {
            return;
        }

        $argumentsCount = $this->countNeedles($stackPtr, $tokens);

        if ($argumentsCount > self::ARGUMENTS_NUMBER_LIMIT) {
            $functionName = $phpcsFile->getDeclarationName($stackPtr);
            $errorData = [$functionName, self::ARGUMENTS_NUMBER_LIMIT];
            $error = 'The %s() function must not have more than %d arguments!';
            $phpcsFile->addError($error, $stackPtr, 'ArgumentsLimit', $errorData);
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
        $argStart = $tokens[$stackPtr]['parenthesis_opener'];
        $argEnd = $tokens[$stackPtr]['parenthesis_closer'];

        $argumentsCount = 0;

        for ($i = $argStart + 1; $i < $argEnd; $i++) {
            if ($tokens[$i]['code'] === T_VARIABLE) {
                $argumentsCount++;
            }
        }

        return $argumentsCount;
    }
}//end class
