Dao开发规范
==========

为什么要有规范
-------------
SQL注入是程序开发中最严重的漏洞之一，小则可能引起数据泄漏，大则甚至能引起整个数据库或Web服务器被人控制。 
Dao开发规范就是一系列在开发过程中如何规避sql注入的方法，来保证系统安全稳定的运行。

一条SQL一个方法 
--------------
通常程序员比较喜欢写一些万能的方法， 
比如一个接口中可以根据id查找用户，也可以根据name查找用户， 
可以查找一个用户，也能查找一堆用户 
这样导致的结果往往就是接口很复杂，一堆if else，不利于接口的管理，也不利于代码的维护 

SQL完整性
--------
通常一条完整的sql语句，都是根据外部业务参数拼接而成 
php常用的做法就是用“.”字符连接字符串和变量，比如   

	'SELECT * FROM pw_user WHERE uid=' . $uid

但是这种方式在拼接变量比较多的情况下， 
容易将sql语句拆的七零八落的，难以理解sql表达的含义 
同时直接拼接变量有严重的注入风险 
所以我们约定，sql不使用“.”字符，所有变量通过占位符替换，即   

	'SELECT * FROM pw_user WHERE groupid=? AND uid IN %s'

安全组装SQL
----------
在sql语句中，常用的是两种占位符，一种是pdo提供的?占位符，一种是sprintf实现的%s占位符   

**pdo占位符**
?是pdo提供的一种安全的变量替换方式，他的适用场景是将变量加上单引号    
比如

	SELECT * FROM pw_user WHERE groupid=?

当变量为1时，替换后的语句为

	SELECT * FROM pw_user WHERE groupid='1'

**安全过滤函数**   

pdo占位符还不能够满足我们开发dao的所有需求，    
因为并不是所有的占位符,我们都需要加上单引号的，     
所以我们寻找了替代方案    
就是使用sprintf实现的%s占位符，    
每一个使用%s替换的变量，必须经过dao基类PwBaseDao中的安全组装函数    

**getTable（表名）**   

	$this->_bindSql('SELECT * FROM %s', $this->getTable());

**sqlSingle**   
sql组装,将数组组装成类似`key`=value等位运算形式返回   
	
	$data = array('name' => '管理员', 'groupid' => 3);
	$this->_bindSql('UPDATE %s SET %s WHERE uid=1', $this->getTable(), $this->sqlSingle($data));

**sqlMulti**   
sql组装,将数组组装成('a1','b1','c1'),('a2','b2','c2')的形式返回    

	$data = array(
  		array('1', '管理员', '3'),
  		array('2', '总版主', '4')
	);
	$this->_bingSql('INSERT INTO %s (uid, name, groupid) VALUES %s', $this->getTable(), $this->sqlMulti($data));

**sqlImplode**  
sql组装,将数组组装成('a1','b1','c1')的形式返回   

	$uids = array(1, 2, 3);
	$this->_bindSql('SELECT * FROM %s WHERE uid IN %s', $this->getTable(), $this->sqlImplode($uids));

**sqlLimit**   
组装sql limit表达式串,并返回组装后的结果   

	$limit = 20;
	$offset = 0;
	$this->_bindSql('SELECT * FROM %s %s', $this->getTable(), $this->sqlLimit($limit, $offset));

