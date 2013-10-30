<?php
/*
package utp
class ph
a static helper class
Author: Vlad Podvorny
*/

class ph {

    public static $testpref = 'test.', $phpsuf = '.php', $starttime = 0, $startmem = 0;

    static function filename2name($filename){ // 'test.MyTest.php' --> 'MyTest'
        if (stripos($filename, self::$testpref)===0) {
            $s = strrev(substr($filename, strlen(self::$testpref)));
            if (stripos($s, strrev(self::$phpsuf))===0) {
                return strrev(substr($s, strlen(self::$phpsuf)));
            }
        }
        return '';
    }

    static function name2filename($name){ // 'MyTest' --> 'test.MyTest.php'
        return self::$testpref . $name . self::$phpsuf;
    }

    static function readdoc($filepath){
        $text = @file_get_contents($filepath);
        if ($text) {
            $m1 = '/**'; $m2 = '*/';
            if (($p1=strpos($text, $m1)) && ($p2=strpos($text, $m2))) {
                $p1 += strlen($m1);
                $frag = trim(substr($text, $p1, $p2-$p1));
                $lines = preg_split("/\r?\n/", $frag);
                $lines = array_map(create_function('$s', 'return trim($s, "* \t");'), $lines);
                return implode("\n", $lines);
            }
        }
        return '';
    }

    static function memformat($val=null){
        if (is_null($val)) $val = memory_get_usage();
        return number_format($val, 0);
    }

    static function mtformat($val=null){
        if (is_null($val)) $val = microtime(true);
        return number_format($val, 5);
    }

    static function zfill($val, $padlen){
        return str_pad($val, $padlen, '0', STR_PAD_LEFT);
    }

    static function deflate($s){ // remove mess from script
        $s = preg_replace("|/\*+.*?\*/|s", '', $s); // remove block comments
        $s = preg_replace("|//.*$|m", "\n", $s);    // remove inline comments
        $s = preg_replace("/[\r\n]+/", "\n", $s);   // remove empty lines
        return trim($s);
    }

    static function quote($s){ // wrap string with double quotes
        return '"' . str_replace('"', '\"', $s) . '"';
    }

    static function squote($s){ // wrap string with single quotes
        return "'" . str_replace("'", '\'', $s) . "'";
    }
    
    static function fmt($val){ // format value as printable string
        if (is_array($val)) {
            $buf = array();
            foreach ($val as $k=>$v) {
                $buf[] = self::fmt($k) . '=>' . self::fmt($v);
            }
            return 'array(' . implode(', ', $buf) . ')';
        }
        if (is_string($val)) return self::quote($val);
        if (is_null($val)) return 'NULL';
        if (true===$val) return 'TRUE';
        if (false===$val) return 'FALSE';
        try {
            return strval($val);
        }
        catch (Exception $e){}
        ob_start();
        print_r($val);
        $val = ob_get_contents();
        ob_end_clean();
        return $val;
    }

    static function p($stuff=''){ // print a paragraph
        if (is_array($stuff) || is_object($stuff)){
            ob_start();
            print_r($stuff);
            $stuff = ob_get_contents();
            ob_end_clean();
        }
        echo $stuff . "\n";
    }

    static function ps($ch='*', $len=80){ // print separator line
        $sep = str_repeat($ch, $len);
        self::p($sep);
    }

    static function h($stuff=''){ // print a header paragraph (a line between separators)
        self::ps();
        self::p($stuff);
        self::ps();
    }

    static function pq($stuff, $single=false){ // print quoted
        $s = ($single) ? self::squote($stuff) : self::quote($stuff);
        self::p($s);
    }

    static function pd($stuff){ // print deflated content
        $s = self::deflate($stuff);
        self::p($s);
    }

    static function pl($txt){ // print content as numbered lines
        $a = preg_split("/\r?\n/", $txt);
        $padlen = strlen(strval(sizeof($a)));
        $cnt = 0;
        foreach ($a as $line) {
            self::p(self::zfill(++$cnt, $padlen) . ': ' . $line);
        }
    }

    static function ts(){ // formatted time gap in seconds
        $dt = microtime(true) - self::$starttime;
        return self::mtformat($dt);
    }

    static function ms(){ // formatted memory delta in bytes
        $dm = memory_get_usage() - self::$startmem;
        return self::memformat($dm);
    }

    static function begin(){
        self::$starttime = microtime(true);
        self::$startmem = memory_get_usage();
    }

    static function stop($msg='', $fname='', $lineno=0){
        $msg = (string)$msg; $details = '';
        if (strlen($fname)) {
            $details = "Terminated in " . basename($fname);
            if ($lineno) $details .= " on line " . $lineno;
        }
        if (strlen($msg)) self::p($msg);
        if ($details) self::p($details);
        exit;
    }

    static function pass(){
        $s = '
########          ##            #######        #######
##      ##       ####         ##       ##    ##       ##
##      ##      ##  ##        ##             ##
##      ##     ##    ##         #######        #######
########      ##########               ##             ##
##           ##        ##     ##       ##    ##       ##
##          ##          ##      #######        #######
';
        self::p($s);
    }

    static function fail(){
        $s = '
##########        ##           ##      ##
##               ####          ##      ##
##              ##  ##         ##      ##
##             ##    ##        ##      ##
########      ##########       ##      ##
##           ##        ##      ##      ##
##          ##          ##     ##      #########
';
        self::p($s);
    }

    static function finish(){
        self::p("Done in " . self::ts() . "s\nTotal memory used: " . ph::memformat() . " bytes\nTest hogged " . self::ms() . " bytes" );
    }

    static function assertcallback($filename, $line, $code){
        self::p();
        self::fail();
        self::p("in file {$filename} on line {$line}\n");
        self::h("False assertion: {$code}");
        self::finish();
    }

    static function exceptionhandler($errno, $errstr, $errfile, $errline) {
        throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
    }
}
?>