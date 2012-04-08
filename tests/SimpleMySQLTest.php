<?php
include_once('PHPUnit/Framework.php');
include_once(dirname(__FILE__).'/../inc_scripts/inc_scripts_common_mysql.php');
 
class SimpleMySQLTest extends PHPUnit_Framework_TestCase
{
    protected $db;
    protected $profile;
    
    function __construct()
    {
    	$this->profile = array(	
    						'username' => 'testuser', 
    						'password'=> 'test*user', 
    						'host' => 'localhost',
    						'database' => 'test'
    						);
    	
    	$this->db = new SimpleMySQL();
    	
    }
    
    function testIsConnected()
    {
    	$prof = $this->profile;
    	unset($prof['database']);
    	
    	$temp_conn = new SimpleMySQL();
    	    	
    	$this->assertTrue($temp_conn->Connect($prof));
    	
    	unset($temp_conn);
    }
    
    /**
     * @depends testIsConnected
     */
    function testIsConnectedAndDatabaseSelected()
    {
    	$this->assertTrue($this->db->Connect($this->profile));
    
    }
    
    /**
     * @depends testIsConnectedAndDatabaseSelected
     */
    function testConnectionErrors()
    {
    	$this->assertFalse($this->db->Error());
    }
    
    /**
     * @depends testIsConnectedAndDatabaseSelected
     */
    function testQueryInsertRowsAffectedAndLastId()
    {
    	$this->db->Query("TRUNCATE test");
    	
    	$result = $this->db->Query("INSERT INTO test (test) VALUES (1),(15),(45),(9658)");
    	
    	$this->assertEquals(MYSQL_TOOLS_UPDATE,$result);
    	$this->assertTrue($this->db->Error($result));
    	$this->assertEquals(4,$this->db->RowsAffected());
    	
    	$this->assertEquals("1",$this->db->LastId());
    }
    
    /**
     * @depends testQueryInsertRowsAffectedAndLastId
     */
    function testQuerySelectEmpty()
    {
    	$result = $this->db->Query("SELECT id FROM test WHERE test=51");
    	
    	$this->assertEquals(MYSQL_TOOLS_EMPTY,$result);
    }
    
    /**
     * @depends testQueryInsertRowsAffectedAndLastId
     */
     function testQueryError()
     {
     	 $result = $this->db->Query("SELECT * FROM test_table");
     	 
     	 $this->assertEquals(MYSQL_TOOLS_ERROR,$result);
     	 $this->assertTrue($this->db->Error($result));
     	 $this->assertTrue(is_array($this->db->Log()));
     	 $this->assertEquals(1,count($this->db->Log()));
     }
     
     function testErrorInvalid()
     {
     	 $this->assertFalse($this->db->Error(9999));
     	 $this->assertFalse($this->db->Error("9999"));
     }
     
     function testDebugStore()
     {
     	 global $_SERVER;
     	      	 
     	 $result = $this->db->Query("SELECT * FROM test_table");
     	 
     	 $this->assertEquals(1,count($this->db->Debug()));
     	 $this->assertEquals(MYSQL_TOOLS_ERROR,$result);
     }
     
     /**
     * @depends testQueryInsertRowsAffectedAndLastId
     */
     function testQueryAsRow()
     {
     	 $result = $this->db->QueryAsRow("SELECT * FROM test");
     	 
     	 $this->assertGreaterThan(0,strlen($result['test']));
     }
     
     /**
     * @depends testQueryInsertRowsAffectedAndLastId
     */
     function testQueryAsArray()
     {
     	 $result = $this->db->QueryAsArray("SELECT * FROM test LIMIT 3");
     	 
     	 $this->assertEquals(3,count($result));
     	 
     	 $keys = array_keys($result);
     	 $this->assertEquals(2,$keys[2]);
     }
     
     /**                            
     * @depends testQueryInsertRowsAffectedAndLastId
     */
     function testQueryAsXml()
     {
     	 $result = $this->db->QueryAsXml("SELECT id, test FROM test");
     	 
     	 $this->assertTrue(is_string($result));
     	 
     	 $xml = simplexml_load_string($result);
     	 
     	 $this->assertFalse(is_bool($xml));
     	 
     	 unset($xml);
     	 	 
     }
     
     function arrayData()
     {
     	 return array(
     	 	 			array('id' => '1', 'test' => '1'),
     	 	 			array('id' => '2', 'test' => '15'),
     	 	 			array('id' => '3', 'test' => '45'),
     	 	 			array('id' => '4', 'test' => '9658')
     	 	 );
     }
     
     function testArrayOne()
     {
     	 $result = $this->arrayData();
     	 $output = _array_one($result,"id");
     	 
     	 $this->assertEquals(4,$output[3]);
     	 $this->assertEquals(4,count($output));
     	 
     	 $this->assertFalse(_array_one(array(),"id"));
     }
     
      function testArrayXml()
     {
     	 $result = $this->arrayData();
     	 $output = _array_xml($result,array('value' => '19'));
     	 
     	 $xml = simplexml_load_string($output);
     	 $this->assertFalse(is_bool($xml));
     	 unset($xml);
     	 
     	 $this->assertRegExp("/<id>/",$output);
     	 $this->assertRegExp("/>19</",$output);
     }
     
     function testArrayCSV()
     {
     	 $result = $this->arrayData();
     	 
     	 $output = _array_csv($result);
     	
     	 $this->assertTrue(is_string($output));
     	 $this->assertRegExp("/\"2\",\"15\"/",$output);
     	 
     }
     
     function testNamedToNumericEnities()
     {
     	 $this->assertEquals("&#201;",namedToNumericEnities("&Eacute;"));
     	 
     	 $this->assertEquals("st. john&#039;s",EncodeText("st. john's"));
     }
     
     function testMySQLSafeDecodeVars()
     {
     	 $unSafe = "st. john's, newfoundland <br />";
     	 
     	 $safe = mysql_safe($unSafe);
     	 
     	 $this->assertRegExp("/&gt;/",$safe,"HTML Characters failed to encode");
     	 $this->assertRegExp("/\\\'/",$safe,"apostrophes are not escaped");
     	 
     	 $decoded = decodeVars(urlencode("this is bob's test"));
     	 
     	 $this->assertEquals("this is bob\&#039;s test",$decoded,"decodeVars failed");
     }
     
     
}
