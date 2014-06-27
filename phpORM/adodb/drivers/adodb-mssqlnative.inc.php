<?php
/* 
V5.08 6 Apr 2009   (c) 2000-2009 John Lim (jlim#natsoft.com). All rights reserved.
  Released under both BSD license and Lesser GPL library license. 
  Whenever there is any discrepancy between the two licenses, 
  the BSD license will take precedence. 
Set tabs to 4 for best viewing.
  
  Latest version is available at http://adodb.sourceforge.net
  
  Native mssql driver. Requires mssql client. Works on Windows. 
    http://www.microsoft.com/sql/technologies/php/default.mspx
  To configure for Unix, see 
   	http://phpbuilder.com/columns/alberto20000919.php3

    $stream = sqlsrv_get_field($stmt, $index, SQLSRV_SQLTYPE_STREAM(SQLSRV_ENC_BINARY));
    stream_filter_append($stream, "convert.iconv.ucs-2/utf-8"); // Voila, UTF-8 can be read directly from $stream

*/

// security - hide paths
if (!defined('ADODB_DIR')) die();

if (!function_exists('sqlsrv_configure')) {
	die("mssqlnative extension not installed");
}

if (!function_exists('sqlsrv_set_error_handling')) {
	function sqlsrv_set_error_handling($constant) {
		sqlsrv_configure("WarningsReturnAsErrors", $constant);
	}
}
if (!function_exists('sqlsrv_log_set_severity')) {
	function sqlsrv_log_set_severity($constant) {
		sqlsrv_configure("LogSeverity", $constant);
	}
}
if (!function_exists('sqlsrv_log_set_subsystems')) {
	function sqlsrv_log_set_subsystems($constant) {
		sqlsrv_configure("LogSubsystems", $constant);
	}
}


//----------------------------------------------------------------
// MSSQL returns dates with the format Oct 13 2002 or 13 Oct 2002
// and this causes tons of problems because localized versions of 
// MSSQL will return the dates in dmy or  mdy order; and also the 
// month strings depends on what language has been configured. The 
// following two variables allow you to control the localization
// settings - Ugh.
//
// MORE LOCALIZATION INFO
// ----------------------
// To configure datetime, look for and modify sqlcommn.loc, 
//  	typically found in c:\mssql\install
// Also read :
//	 http://support.microsoft.com/default.aspx?scid=kb;EN-US;q220918
// Alternatively use:
// 	   CONVERT(char(12),datecol,120)
//
// Also if your month is showing as month-1, 
//   e.g. Jan 13, 2002 is showing as 13/0/2002, then see
//     http://phplens.com/lens/lensforum/msgs.php?id=7048&x=1
//   it's a localisation problem.
//----------------------------------------------------------------


// has datetime converstion to YYYY-MM-DD format, and also mssql_fetch_assoc
if (ADODB_PHPVER >= 0x4300) {
// docs say 4.2.0, but testing shows only since 4.3.0 does it work!
	ini_set('mssql.datetimeconvert',0); 
} else {
    global $ADODB_mssql_mths;		// array, months must be upper-case
	$ADODB_mssql_date_order = 'mdy'; 
	$ADODB_mssql_mths = array(
		'JAN'=>1,'FEB'=>2,'MAR'=>3,'APR'=>4,'MAY'=>5,'JUN'=>6,
		'JUL'=>7,'AUG'=>8,'SEP'=>9,'OCT'=>10,'NOV'=>11,'DEC'=>12);
}

//---------------------------------------------------------------------------
// Call this to autoset $ADODB_mssql_date_order at the beginning of your code,
// just after you connect to the database. Supports mdy and dmy only.
// Not required for PHP 4.2.0 and above.
function AutoDetect_MSSQL_Date_Order($conn)
{
    global $ADODB_mssql_date_order;
	$adate = $conn->GetOne('select getdate()');
	if ($adate) {
		$anum = (int) $adate;
		if ($anum > 0) {
			if ($anum > 31) {
				//ADOConnection::outp( "MSSQL: YYYY-MM-DD date format not supported currently");
			} else
				$ADODB_mssql_date_order = 'dmy';
		} else
			$ADODB_mssql_date_order = 'mdy';
	}
}

class ADODB_mssqlnative extends ADOConnection {
	var $databaseType = "mssqlnative";	
	var $dataProvider = "mssqlnative";
	var $replaceQuote = "''"; // string to use to replace quotes
	var $fmtDate = "'Y-m-d'";
	var $fmtTimeStamp = "'Y-m-d H:i:s'";
	var $hasInsertID = true;
	var $substr = "substring";
	var $length = 'len';
	var $hasAffectedRows = true;
	var $poorAffectedRows = false;
	var $metaDatabasesSQL = "select name from sys.sysdatabases where name <> 'master'";
	var $metaTablesSQL="select name,case when type='U' then 'T' else 'V' end from sysobjects where (type='U' or type='V') and (name not in ('sysallocations','syscolumns','syscomments','sysdepends','sysfilegroups','sysfiles','sysfiles1','sysforeignkeys','sysfulltextcatalogs','sysindexes','sysindexkeys','sysmembers','sysobjects','syspermissions','sysprotects','sysreferences','systypes','sysusers','sysalternates','sysconstraints','syssegments','REFERENTIAL_CONSTRAINTS','CHECK_CONSTRAINTS','CONSTRAINT_TABLE_USAGE','CONSTRAINT_COLUMN_USAGE','VIEWS','VIEW_TABLE_USAGE','VIEW_COLUMN_USAGE','SCHEMATA','TABLES','TABLE_CONSTRAINTS','TABLE_PRIVILEGES','COLUMNS','COLUMN_DOMAIN_USAGE','COLUMN_PRIVILEGES','DOMAINS','DOMAIN_CONSTRAINTS','KEY_COLUMN_USAGE','dtproperties'))";
	var $metaColumnsSQL = # xtype==61 is datetime
        "select c.name,t.name,c.length,
	    (case when c.xusertype=61 then 0 else c.xprec end),
	    (case when c.xusertype=61 then 0 else c.xscale end) 
	    from syscolumns c join systypes t on t.xusertype=c.xusertype join sysobjects o on o.id=c.id where o.name='%s'";
	var $hasTop = 'top';		// support mssql SELECT TOP 10 * FROM TABLE
	var $hasGenID = true;
	var $sysDate = 'convert(datetime,convert(char,GetDate(),102),102)';
	var $sysTimeStamp = 'GetDate()';
	var $maxParameterLen = 4000;
	var $arrayClass = 'ADORecordSet_array_mssqlnative';
	var $uniqueSort = true;
	var $leftOuter = '*=';
	var $rightOuter = '=*';
	var $ansiOuter = true; // for mssql7 or later
	var $identitySQL = 'select SCOPE_IDENTITY()'; // 'select SCOPE_IDENTITY'; # for mssql 2000
	var $uniqueOrderBy = true;
	var $_bindInputArray = true;
	var $_dropSeqSQL = "drop table %s";
	
	function ADODB_mssqlnative() 
	{		
        if ($this->debug) {
            error_log("<pre>");
            sqlsrv_set_error_handling( SQLSRV_ERRORS_LOG_ALL );
            sqlsrv_log_set_severity( SQLSRV_LOG_SEVERITY_ALL );
            sqlsrv_log_set_subsystems(SQLSRV_LOG_SYSTEM_ALL);
            sqlsrv_configure('warnings_return_as_errors', 0);
        } else {
            sqlsrv_set_error_handling(0);
            sqlsrv_log_set_severity(0);
            sqlsrv_log_set_subsystems(SQLSRV_LOG_SYSTEM_ALL);
            sqlsrv_configure('warnings_return_as_errors', 0);
        }
	}

	function ServerInfo()
	{
    	global $ADODB_FETCH_MODE;
		if ($this->fetchMode === false) {
			$savem = $ADODB_FETCH_MODE;
			$ADODB_FETCH_MODE = ADODB_FETCH_NUM;
		} else 
			$savem = $this->SetFetchMode(ADODB_FETCH_NUM);
		$arrServerInfo = sqlsrv_server_info($this->_connectionID);
		$arr['description'] = $arrServerInfo['SQLServerName'].' connected to '.$arrServerInfo['CurrentDatabase'];
		$arr['version'] = $arrServerInfo['SQLServerVersion'];//ADOConnection::_findvers($arr['description']);
		return $arr;
	}
	
	function IfNull( $field, $ifNull ) 
	{
		return " ISNULL($field, $ifNull) "; // if MS SQL Server
	}
	
	function _insertid()
	{
	// SCOPE_IDENTITY()
	// Returns the last IDENTITY value inserted into an IDENTITY column in 
	// the same scope. A scope is a module -- a stored procedure, trigger, 
	// function, or batch. Thus, two statements are in the same scope if 
	// they are in the same stored procedure, function, or batch.
		return $this->GetOne($this->identitySQL);
	}

	function _affectedrows()
	{
        return sqlsrv_rows_affected($this->_queryID);
	}
	
	function CreateSequence($seq='adodbseq',$start=1)
	{
		if($this->debug) error_log("<hr>CreateSequence($seq,$start)");
        sqlsrv_begin_transaction($this->_connectionID);
		$start -= 1;
		$this->Execute("create table $seq (id int)");//was float(53)
		$ok = $this->Execute("insert into $seq with (tablock,holdlock) values($start)");
		if (!$ok) {
            if($this->debug) error_log("<hr>Error: ROLLBACK");
            sqlsrv_rollback($this->_connectionID);
			return false;
		}
        sqlsrv_commit($this->_connectionID);
		return true;
	}

	function GenID($seq='adodbseq',$start=1)
	{
        if($this->debug) error_log("<hr>GenID($seq,$start)");
        sqlsrv_begin_transaction($this->_connectionID);
		$ok = $this->Execute("update $seq with (tablock,holdlock) set id = id + 1");
		if (!$ok) {
			$this->Execute("create table $seq (id int)");
			$ok = $this->Execute("insert into $seq with (tablock,holdlock) values($start)");
			if (!$ok) {
                if($this->debug) error_log("<hr>Error: ROLLBACK");
                sqlsrv_rollback($this->_connectionID);
				return false;
                        }
                }
        }
}
