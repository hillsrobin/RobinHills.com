<?php
include_once('PHPUnit/Framework.php');
include_once(dirname(__FILE__).'/../inc_scripts/inc_scripts_class_utils.php');
 
class UtilsTest extends PHPUnit_Framework_TestCase
{
    public function testUniqueNameGenerated()
    {
		$filename = Utils::UniqueName("test.txt");
		
		$this->assertGreaterThan(0,strlen($filename));
		$this->assertRegExp("/[0-9]{12}\.txt$/",$filename);
	}
	
	public function testSimpleCipher()
	{
		$result = Utils::SimpleCipher("test");
		
		$this->assertEquals("grfg",$result);
	}

	public function testNl2pWithLineBreaks()
	{
		$input = "test string.\r\n
		Another Test string";
		
		$output =  Utils::nl2p($input,true);
		$this->assertRegExp("/^<p>/i",$output);
		$this->assertRegExp("/<\/p>$/i",$output);
		$this->assertRegExp("/test string\.<br \/>/i",$output);
	}
    
	public function testNl2pWithOutLineBreaks()
	{
		$input = "test string.\r\n
		Another Test string";
		
		$output =  Utils::nl2p($input,false);
		
		$this->assertRegExp("/^<p>/i",$output);
		$this->assertRegExp("/<\/p>$/i",$output);
		$this->assertRegExp("/test string\.\r<\/p>/i",$output);
	}
}
