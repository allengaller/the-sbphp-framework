<?
/**
 * Filename:	mysql.php
 * 
 * Function: 	Basic Database Operation for MySQL5
 * 
 * Description:	全局MySQL功能函数
 *
 * Support:		PHP versions 4 and 5
 *
 * Framework:	KylinPHP(tm) : Rapid Development Framework (http://vkylin.net)
 * 				Copyright 2013, SNSSHOP Inc.
 *
 * Licensed:	The MIT License
 * 				Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2013, SNSSHOP Inc.
 * @link          http://vkylin.net KylinPHP(tm) Project
 * @package       kylin
 * @subpackage    kylin.kylin
 * @since         KylinPHP(tm) v 0.1
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author 		  Binko
 */

class sql_db
{

	var $db_connect_id;
	var $query_result;
	var $row = array();
	var $rowset = array();
	var $num_queries = 0;
	var $in_transaction = 0;

	// Constructor
	function sql_db($sqlserver, $sqluser, $sqlpassword, $database, $persistency = 0)
	{
		$this->persistency = $persistency;
		$this->user = $sqluser;
		$this->password = $sqlpassword;
		$this->server = $sqlserver;
		$this->dbname = $database;

		$this->db_connect_id = ($this->persistency) ? @mysql_pconnect($this->server, $this->user, $this->password) : @mysql_connect($this->server, $this->user, $this->password);
		
		if( $this->db_connect_id ) {	
			mysql_query("set names utf8"); 

			$dbselect = mysql_select_db($this->dbname);
			if(!$dbselect) {
				mysql_close($this->db_connect_id);
				$this->db_connect_id = $dbselect;
			}
			return $this->db_connect_id;
		} else {
			return false;
		}

	}

	function sql_close()
	{
		return ( $this->db_connect_id )? mysql_close($this->db_connect_id) : false;
	}

	// Base query method
	function sql_query($query = "", $buffer = 1)
	{
		unset($this->query_result);

		if($query) {
			$this->query_result = (!$buffer && function_exists('mysql_unbuffered_query'))? mysql_unbuffered_query($query, $this->db_connect_id) : mysql_query($query, $this->db_connect_id);
			
			if( $this->query_result ) {
				unset($this->row[$this->query_result]);
				unset($this->rowset[$this->query_result]);

				$this->num_queries++;
				return $this->query_result;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	// 返回结果集中行的数目,此函数仅对 SELECT 语句有效。
	function sql_numrows($query_id = 0)
	{
		return ( $query_id=($query_id) ? $query_id : $this->query_result ) ? mysql_num_rows($query_id) : false;
	}

	// 返回被 INSERT，UPDATE 或者 DELETE 查询所影响到的行的数目，
	function sql_affectedrows()
	{
		return ( $this->db_connect_id ) ? mysql_affected_rows($this->db_connect_id) : false;
	}

	// 返回结果集中字段的数目
	function sql_numfields($query_id = 0)
	{
		return ( $query_id=($query_id) ? $query_id : $this->query_result ) ? mysql_num_fields($query_id) : false;
	}

	// 返回结果中指定字段的字段名
	function sql_fieldname($offset, $query_id = 0)
	{
		return ( $query_id=($query_id) ? $query_id : $this->query_result ) ? mysql_field_name($query_id, $offset) : false;
	}

	// 返回结果集中指定字段的类型
	function sql_fieldtype($offset, $query_id = 0)
	{
		return ( $query_id=($query_id) ? $query_id : $this->query_result ) ? mysql_field_type($query_id, $offset) : false;
	}

	// 从结果集中取得一行作为关联数组，或数字数组，或二者兼有
	function sql_fetchrow($query_id = 0)
	{
		if( $query_id=($query_id) ? $query_id : $this->query_result )
			return ( $this->row[$query_id] = mysql_fetch_array($query_id, MYSQL_ASSOC) );
		else {
			return false;
		}
	}

	//将所有结果保存在一个数组中返回
	function sql_fetchrowset($query_id = 0)
	{
		if( $query_id=($query_id) ? $query_id : $this->query_result ) {
			unset($this->rowset[$query_id]);
			unset($this->row[$query_id]);

			while($this->rowset[$query_id] = mysql_fetch_array($query_id, MYSQL_ASSOC)) {
				$result[] = $this->rowset[$query_id];
			} if (!empty($result)) {
				return $result;	
			} else {
				return array();
			}
		} else {
			return array();
		}
	}
	
	//将一条记录保存在一个数组中返回
	function sql_fetchRecord($queryStr) 
	{
		$result = $this->sql_query( $queryStr );
		if( $this->sql_numrows($result) >0 )
			return $this->sql_fetchrow($result) ;
		else {
			return false ;
		}
	}
				
	function sql_fetchfield($field, $rownum = -1, $query_id = 0)
	{
		if( $query_id=($query_id) ? $query_id : $this->query_result ) {
			if( $rownum > -1 ) {
				$result = mysql_result($query_id, $rownum, $field);
			} else {
				if( empty($this->row[$query_id]) && empty($this->rowset[$query_id]) ) {
					if( $this->sql_fetchrow() )
						$result = $this->row[$query_id][$field];
				} else {
					if( $this->rowset[$query_id] ) {
						$result = $this->rowset[$query_id][$field];
					} else if( $this->row[$query_id] ) {
						$result = $this->row[$query_id][$field];
					}
				}
			}
			return $result;
		} else {
			return array();
		}
	}

	// 移动内部结果的指针
	function sql_rowseek($rownum, $query_id = 0)
	{
		return ( $query_id=($query_id) ? $query_id : $this->query_result ) ? mysql_data_seek($query_id, $rownum) : false;
	}

	// 取得上一步 INSERT 操作产生的 ID 
	function sql_insertid()
	{
		return ( $this->db_connect_id ) ? mysql_insert_id($this->db_connect_id) : false;
	}

	// 释放结果内存
	function sql_freeresult($query_id = 0)
	{
		if ( $query_id=($query_id) ? $query_id : $this->query_result ) {
			unset($this->row[$query_id]);
			unset($this->rowset[$query_id]);

			mysql_free_result($query_id);
			return true;
		} else {
			return false;
		}
	}

	// 返回上一个 MySQL 操作产生的文本错误信息
	function sql_error()
	{
		$result['message'] = mysql_error($this->db_connect_id);
		$result['code'] = mysql_errno($this->db_connect_id);
		return $result;
	}
}
?>
