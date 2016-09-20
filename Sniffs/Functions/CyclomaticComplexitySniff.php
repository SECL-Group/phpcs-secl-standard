<?php
/**
 * Cyclomatic Complexity Test.
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
 * Cyclomatic Complexity Test.
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
class Secl_Sniffs_Functions_CyclomaticComplexitySniff extends
    Secl_Sniffs_Functions_AbstractFunctionSniff
{
    /**
     * Cyclomatic Complexity limit for the function
     * The number of branch points plus one
     */
    const COMPLEXITY_LIMIT = 5;

    /**
     * Branch points
     */
    const BRANCH_POINTS
        = [
            T_IF, // if
            T_CASE, // case
            T_WHILE, // while
            T_FOR, // for
            T_FOREACH, // foreach
            T_CATCH, // catch
            T_BOOLEAN_AND, // &&
            T_BOOLEAN_OR, // ||
            T_INLINE_THEN, // ?
        ];

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

        $cyclomaticComplexity = $this->countNeedles($stackPtr, $tokens);

        if ($cyclomaticComplexity > self::COMPLEXITY_LIMIT) {
            $functionName = $phpcsFile->getDeclarationName($stackPtr);
            $errorData = [$functionName, self::COMPLEXITY_LIMIT];
            $error = 'The %s() function must not have the complexity more than %d!';
            $phpcsFile->addError($error, $stackPtr, 'CyclomaticComplexity', $errorData);
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

        $branchPointCount = 0;

        for ($i = $openingBrace + 1; $i < $closingBrace - 1; $i++) {
            $code = $tokens[$i]['code'];

            if (in_array($code, self::BRANCH_POINTS)) {
                $branchPointCount++;
            }
        }

        $cyclomaticComplexity = $branchPointCount + 1;

        return $cyclomaticComplexity;
    }
}//end class
