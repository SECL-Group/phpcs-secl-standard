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
 * Function Size Test.
 *
 * Checks maximum lines number of the function.
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
class Secl_Sniffs_Functions_FunctionSizeSniff extends
    Secl_Sniffs_Functions_AbstractFunctionSniff
{
    /**
     * Maximum lines number of the function
     */
    const FUNCTION_MAX_SIZE = 15;

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

        $functionEffectiveSize = $this->countNeedles($stackPtr, $tokens);

        if ($functionEffectiveSize > self::FUNCTION_MAX_SIZE) {
            $errorMessage = 'The %s() function must not be larger than %d lines!';
            $errorType = 'FunctionSize';
            $functionName = $phpcsFile->getDeclarationName($stackPtr);
            $errorData = [$functionName, self::FUNCTION_MAX_SIZE];
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
        $firstFunctionLine = $tokens[$tokens[$stackPtr]['parenthesis_closer']]['line'];
        $closingBrace = $tokens[$stackPtr]['scope_closer'];
        $endFunctionLine = $tokens[$closingBrace]['line'];
        $functionTotalSize = $endFunctionLine - $firstFunctionLine;

        $blankLineCount = 0;

        for ($i = $openingBrace + 1; $i < $closingBrace - 1; $i++) {
            if ($tokens[$i]['column'] === 1 && $tokens[$i]['length'] === 0) {
                $blankLineCount++;
            }
        }

        $functionEffectiveSize = ($functionTotalSize - $blankLineCount);

        return $functionEffectiveSize;
    }
}//end class
