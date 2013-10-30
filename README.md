php-utp
=======

Unit Test Page for PHP Web Applications (A Minimalistic PHP Unit Test framework)

Author: Vlad Podvorny

Requirements: PHP5, webserver

Current version: 0.1

Demo URL: http://fishwasher.com/demo/php-utp/

Directories and Files
------------------------

    /lib                <-- place classes/scripts being tested here, or specify another location as TESTDIR in mute.php, and get rid of this one
        
    /test               <-- contains custom tests and application includes:
        test.<Name>.php     <-- common pattern for custom unit test called <Name>

    /test/app                <-- contains application includes:
            ph.php              <-- a helper static class ("ph" is for "print helper")
            testlist.php        <-- test list front page generator
            links.php           <-- links box include
            login.php           <-- user authentication include

    README.md           <-- this file
    utp.php             <-- UTP entry point; OK to rename (mentioned in index.php only)
    index.php           <-- merely includes utp.php; when it comes to integration, it's yours!
