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
class Secl_Sniffs_Functions_FunctionSizeSniff extends Secl_Sniffs_Functions_AbstractFunctionSniff
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
     * @param int   $stackPtr
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

        $negligibleLineCount = $this->insideFunctionLoop($tokens, $openingBrace, $closingBrace);

        $functionEffectiveSize = ($functionTotalSize - $negligibleLineCount);

        return $functionEffectiveSize;
    }

    /**
     * @param array $tokens
     * @param int   $openingBrace
     * @param int   $closingBrace
     *
     * @return int
     */
    private function insideFunctionLoop($tokens, $openingBrace, $closingBrace)
    {
        $negligibleLineCount = 0;

        for ($i = $openingBrace + 1; $i < $closingBrace - 1; $i++) {
            list($lineCountForIteration, $i) = $this->negligibleLineCountForIteration($tokens, $i);
            $negligibleLineCount = $negligibleLineCount + $lineCountForIteration;
        }

        return $negligibleLineCount;
    }

    /**
     * @param array $tokens
     * @param int   $iterationIndex
     *
     * @return array
     */
    private function negligibleLineCountForIteration($tokens, $iterationIndex)
    {
        $negligibleLineCount = 0;

        list($docCommentLineCount, $iterationIndex) = $this->docComment($tokens, $iterationIndex);

        if ($docCommentLineCount) {
            $negligibleLineCount = $negligibleLineCount + $docCommentLineCount;
        } else {
            $negligibleLineCount = $negligibleLineCount + $this->emptyString($tokens, $iterationIndex);
            $negligibleLineCount = $negligibleLineCount + $this->inlineComment($tokens, $iterationIndex);
        }

        return [$negligibleLineCount, $iterationIndex];
    }

    /**
     * @param array $tokens
     * @param int   $iterationIndex
     *
     * @return array
     */
    private function docComment($tokens, $iterationIndex)
    {
        if ($tokens[$iterationIndex]['code'] === T_DOC_COMMENT_OPEN_TAG) {
            $commentOpenerLine = $tokens[$iterationIndex]['line'];
            $commentCloserToken = $tokens[$iterationIndex]['comment_closer'];
            $commentCloserLine = $tokens[$commentCloserToken]['line'];
            $negligibleLineCount = $commentCloserLine - $commentOpenerLine + 1;

            return [$negligibleLineCount, $commentCloserToken];
        }

        return [0, $iterationIndex];
    }

    /**
     * @param array $tokens
     * @param int   $iterationIndex
     *
     * @return int
     */
    private function inlineComment($tokens, $iterationIndex)
    {
        if (T_COMMENT === $tokens[$iterationIndex]['code']) {
            return 1;
        }

        return 0;
    }

    /**
     * @param array $tokens
     * @param int   $iterationIndex
     *
     * @return int
     */
    private function emptyString($tokens, $iterationIndex)
    {
        if ($tokens[$iterationIndex]['column'] === 1 && $tokens[$iterationIndex]['length'] === 0) {
            return 1;
        }

        return 0;
    }
}//end class
