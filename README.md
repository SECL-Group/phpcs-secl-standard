# Secl Group PHP_CodeSniffer Maintainability Coding Standard

PHP_CodeSniffer maintainability standard for [Secl Group applications](http://seclgroup.com/).

Everyone is probably familiar with a situation in which, with the development of a project, the implementation of new functions becomes more time-consuming and expensive. And, unfortunately, it often happens that the price starts to significantly outweigh the possible benefit that can be obtained from the implementation of the function.

Having analyzed a number of projects, the experts of Software Improvement Group (SIG) developed a set of simple principles and rules with the help of which you can make the situation much better. Some of these principles can be easily controlled in automatic mode. For this purpose, special software was created for such languages as Java and C#. We propose the easiest implementation of automatic control for PHP development. In this option, we have carried out control of these basic principles:
- A function should be no longer than 15 lines of code;
- The cyclomatic complexity of a function should not exceed 5;
- Functions should not take more than 4 input arguments.

Once such control has been implemented in our company, the quality of development has significantly improved. Therefore, the code has become much easier to understand and maintain.  

We propose you a basic option of the solution for automatic control. The standard can be easily integrated into a version control system. We recommend using it combined with other stylistic standards of your company.

This project was based on the principles provided by Joost Visser in his book [Building Maintainable Software](https://github.com/oreillymedia/building_maintainable_software) (ISBN print: 978-1-4919-5352-5, ISBN eBook: 978-1-4919-5348-8). For more information about software maintainability, we recommend that you read the book.

## Installation

This coding standard can be installed via composer or used in your PHP_CodeSniffer install over PECL. Both ways are described below, but the way of using composer is recommended:

### Using Composer

1. Install The standard as a dependency of your composer based project (It will install a composer version of PHP_CodeSniffer as a dependency):

        $ php composer.phar require --dev secl-group/phpcs-secl-standard:~1.0.0

2. Profit!

        $ bin/phpcs --standard=vendor/secl-group/phpcs-secl-standard/secl-group/phpcs/Secl --extensions=php src/

### Using PEAR

1. Install PHP_CodeSniffer:

        $ pear install PHP_CodeSniffer

2. Find your PEAR directory:

        $ pear config-show | grep php_dir

3. Copy, symlink or check out this repository to `Secl` folder inside the phpcs `Standards` directory:

        $ cd /path/to/pear/PHP/CodeSniffer/Standards
        $ git clone https://github.com/SECL-Group/phpcs-secl-standard Secl

4. Set Secl as your default coding standard if you want:

        $ phpcs --config-set default_standard Secl

5. Profit!

        $ phpcs --standard=Secl --extensions=php src/

# Contributing

If you do contribute code to these Sniffs, please make sure it conforms to the PEAR coding standards
 and that the Secl-coding-standard unit tests are still passed.

To check the coding standard, run from the Secl-coding-standard source root:

    $ phpcs --ignore=*/tests/* --standard=Secl . -n

# For unit-tests

    $ composer install
    $ cp phpunit.xml.dist phpunit.xml
    
Make links to a vendor directory, use only absolute paths – otherwise, CORRECT the LINKS!
    
    $ mkdir /path/to/phpcs/vendor/squizlabs/php_codesniffer/CodeSniffer/Standards/Secl
      ln -sf /path/to/phpcs/Sniffs /path/to/phpcs/vendor/squizlabs/php_codesniffer/CodeSniffer/Standards/Secl/Sniffs
      ln -sf /path/to/phpcs/Tests /path/to/phpcs/vendor/squizlabs/php_codesniffer/CodeSniffer/Standards/Secl/Tests
      ln -sf /path/to/phpcs/ruleset.xml /path/to/phpcs/vendor/squizlabs/php_codesniffer/CodeSniffer/Standards/Secl/ruleset.xml
      ln -sf /path/to/phpcs/phpunit.xml /path/to/phpcs/vendor/squizlabs/php_codesniffer/CodeSniffer/Standards/Secl/phpunit.xml

The unit tests are run from the Secl directory which includes the vendor directory.

    $ vendor/bin/phpunit -c phpunit.xml vendor/squizlabs/php_codesniffer/tests/AllTests.php
