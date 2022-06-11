<?php
class db{
	public $sql = '';
	public $inq = '';
	public $sqlcount = 0;
	public $pfx = '';
	private $connid = 0;
	
	/**
	 * Когда не стырил датабазу и приходиться писать коменты
	 * При инициализации подключается к MySQL и подключается к нужной БД
	 * 
	 * @param $server название хоста
	 * @param $user логин
	 * @param $password пароль
	 * @param $dbname название бд
	 * @param $pfx префикс таблиц, по умолчанию tf_, т.е. в любом запросе к названию таблиц 
	 * будет добавлятся tf_
	 * @param $charset кодировка
	 */
	function __construct( $server, $user, $password, $dbname, $pfx='tf_', $charset="utf8" ){
		if( $this->connid = @mysqli_connect($server, $user, $password) ){
			$this->pfx = $pfx;
			if( mysqli_select_db($this->connid, $dbname) ){
				$this->query("SET NAMES '".$charset."'") && $this->query("SET CHARSET '".$charset."'") && $this->query("SET CHARACTER SET '".$charset."'") && $this->query("SET SESSION collation_connection = '{$charset}_general_ci'");
			}
		}else{
			$this->error();
		}
	}
	
	/**
	 * Выполняет SQL запрос, заменяя #_ на заданный в настройках префикс 
	 */
	function query($sql){
		$this->sql = str_replace('#_',$this->pfx,$sql);
		$this->sqlcount++;
		($this->inq = mysqli_query($this->connid, $this->sql))||$this->error();
		return $this->inq;
	}
	
	/**
	 * Возвращает последний выполненный запрос
	 */
	function last(){
		return $this->sql;
	}
	
	/**
	 * Возвращает одну запись из БД соответствующую запросу
	 *
	 * @param $sql SQL запрос
	 * @param $field если не задано то возвращается вся запись, иначе возвращается значение поля $field
	 * @example $db->getRow('select * from #_book where id=12'); // вернет array('id'=>12,'name'=>'Tolkien' ...)
	 * @example $db->getRow('select name from #_book where id=12',name); // вернет 'Tolkien'
	 */
	function getRow( $sql,$field='' ){
		$item = mysqli_fetch_array($this->query($sql));
		return ($field=='')?$item:$item[$field]; 
	}
	
	/**
	 * Перебирает все записи из запроса и передает их в callback функцию
	 *
	 * @param $sql SQL запрос, с префиксом #_ 
	 * @param $callback функция, вызываемая к каждой записи запроса, 
	 * в параметрах 1) массив, содержащий данные полученной записи 2)указатель на db
	 * @return Возвращает db
	 */
	public function each( $sql,$callback ){
		$this->query($sql);
		if( is_callable($callback) )
			while($item = mysqli_fetch_array($this->inq))
				call_user_func($callback,$item,$this);
		return $this;
	}
	
	/**
	 * Изымает лишь запись по ее идентификатору, по умолчанию id
	 *
	 * @param $sTable название таблицы без префикса
	 * @param $id значение идентификатора
	 * @param $fieldname поле по которому производится сравнение, по умолчанию id
	 * @param $field значение поля, которое необходимо вернуть. Если не указано то возвращается вся запись
	 * @return ассоциативный массив либо конкретное значение пи заданном $field
	 * @example $db->getRowById('book',12); // вернет запись о книге с id=12
	 * @example $db->getRowById('book','Tolkien','name'); // вернет запись о книге с названием которое содержит Tolkien
	 * @example $db->getRowById('book',12,'id','name'); // вернет название книги с id=12
	 */
	public function getRowById( $sTable, $id,$fieldname='id',$field='' ) {
		return $this->getRow("SELECT * FROM `#_".$sTable."` WHERE `$fieldname` ='".$this->escape($id)."'",$field);
	}
	
	/**
	 * Проверяет существует ли запись в таблице с таким идентификатором, если существует то возвращает идентификатор
	 * иначе возвращает false
	 *
	 * @param $sTable название таблицы без префикса
	 * @param $id значение идентификатора
	 * @param $fieldname поле по которому производится сравнение, по умолчанию id
	 * @param $allf дополнительные параметры запроса, обычное sql сравнение
	 * @param $field поле которое необходимо вернуть в случае удачи, по умолчанию равно $fieldname
	 * @return При удаче возвращает значение поля $field, иначе false
	 * @example if( $db->exists('book',12) ) echo 'Книга существует';
	 * @example if( $db->exists('book','Tolkien','name')!==false ) echo 'Книга содерщащая Tolkien существует';
	 * @example if( $db->exists('book','Tolkien','name','active="yes" and public="12.09.2008"') ) 
	 *	echo 'Книга содерщащая Tolkien опубликованная 12.09.2008 существует';
	 * @example if( ($name=$db->exists('book','%Tolkien%','name','','izdatel'))!==false ) 
	 *	echo 'Книга содерщащая Tolkien существует ее издал '.$name;
	 */
	public function exists($sTable,$id,$fieldname='id',$allf='',$field = ''){
		if( !$field )
			$field = $fieldname;
		$item = $this->getRow('select '.$field.' from '.$this->pfx.$sTable.' where `'.$fieldname.'`=\''.$this->escape($id).'\' '.$allf);
		return isset($item[$field])?$item[$field]:false;
	}
	
	/**
	 * @deprecated 1.7 Используйте getRows
	 */
	function loadResults( $sql,$field = '' ){
		return $this->getRows($sql,$field);
	}
	/**
	 * Выдает массив всех записей из запроса
	 *
	 * @param $sql SQL запрос, с префиксом #_ 
	 * @param $field если указано это поле, то результирующий массив будет состоять только из значений этого поля
	 * @return Array
	 */
	function getRows( $sql,$field = '' ){
		$inq = $this->query($sql);$items = array();
		while($item = @mysqli_fetch_array($inq)) $items[] = ($field=='')?$item:$item[$field]; 
		return $items;
	}
	
	/**
	 * Экранирует значение
	 */
	function escape($sql){
        return mysqli_real_escape_string($this->connid,$sql);
    }
		
	/**
	 * Вставка данных в таблицу
	 *
	 * @param $sTable название таблицы без префикса
	 * @param $values либо строка вида id=12,name="Tolkien", 
	 * либо ассоциативный массив вида array('id'=>12,'name'=>'Tolkien')
	 * в случае ассоциативного массива экранировать данные не требуется
	 * @example $db->insert('book','id=12,name="'.$db->escape('Tolkien').'"');
	 * @example $db->insert('book',array('id'=>12,'name'='Tolkien'));
	 */
	function insert( $sTable,$values ){
		$ret = $this->_arrayKeysToSet($values);
		return $this->query('insert into #_'.$sTable.' set '.$ret);
	  return false;
	}
	
	/**
	 * Возвращает значение перичного ключа последней вставленной записи
	 */
	function insertid(){
		return mysqli_insert_id($this->connid);
	}
	
	/**
	 * Обновление данных в таблице
	 *
	 * @param $sTable название таблицы без префикса
	 * @param $values либо строка вида id=12,name="Tolkien", 
	 * либо ассоциативный массив вида array('id'=>12,'name'=>'Tolkien')
	 * в случае ассоциативного массива экранировать данные не требуется
	 * @param $sWhere условия соответсвия
	 * @example $db->update('book','id=12,name="'.$db->escape('Tolkien').'"','id=5');
	 * @example $db->update('book',array('id'=>12,'name'='Tolkien'),'where name like %Tolkien%');
	 */
	public function update( $sTable, $values, $sWhere=1 ){
		$ret = $this->_arrayKeysToSet($values);
		return $this->query('update '.$this->pfx.$sTable.' set '.$ret.' where '.$sWhere);
	}
	/**
	 * Удаление данных соответствующих словию
	 */
	public function delete( $sTable, $sWhere ){
		return $this->query('delete from '.$this->pfx.$sTable.' where '.$sWhere);
	}

	/**
	 * Save user data in profile
	 * Теоритически можно через getRow и update, но мне пока-что в падло
	 * @param тут и так все понятно
	 */
	public function saveUserInfo($steamid, $name, $dota, $cs_go, $age, $lang, $img_full)
	{
		$registered = $this->query("SELECT steamid FROM #_user WHERE steamid = '".$steamid."'");
		$tableRow = mysqli_fetch_assoc( $registered );
		$cs_go = $this->delRankPref($cs_go);

		if ($tableRow['steamid'] == $steamid) {
			$sql = "UPDATE #_user
			SET name = '".$name."', cs_go = '".$cs_go."', age = '".$age."', dota = '".$dota."', lang = '".$lang."', image_full = '".$img_full."'
			WHERE steamid = '".$steamid."'";
			$result = $this->query($sql);
		}
		else {
			$sql = "INSERT INTO `#_user` (steamid, name, dota, age, cs_go, lang, image_full)
			VALUES ('".$steamid."', '".$name."', '".$dota."', '".$age."', '".$cs_go."', '".$lang."', '".$img_full."')";
			$result = $this->query($sql);
		}
	}
	/**
	 * Save user data when logged in
	 */
    public function saveUserId($steamid = '', $name='', $img_full='')
    {
        
    	$registered = $this->query("SELECT steamid FROM `#_user` WHERE steamid = '".$steamid."'");
		$tableRow = mysqli_fetch_assoc( $registered );
		if ($tableRow['steamid'] == $steamid) {
	        $sql = "UPDATE `#_user`
			SET name = '".$name."', image_full = '".$img_full."'
			WHERE steamid = '".$steamid."'";
	        $result = $this->query($sql);
	    }
	    else {
	    	$sql = "INSERT INTO `#_user` (steamid, name, cs_go, team_num, image_full)
	        VALUES ('$steamid', '$name', '1', '2', '$img_full')";
	        $result = $this->query($sql);
	    }

    }
    /**
	 * Save any User data.
	 * Used for saving ranks mostly
     */
    public function saveUserData($steamid, $column, $data)
    {
    	$registered = $this->query("SELECT steamid FROM #_user WHERE steamid = '".$steamid."'");
		$tableRow = mysqli_fetch_assoc( $registered );
		if ($column == "cs_go") {
			$data = $this->delRankPref($data);
		}
		if ($tableRow['steamid'] == $steamid) {
	        $sql = "UPDATE #_user
			SET ".$column." = '".$data."'
			WHERE steamid = '".$steamid."'";
	        $result = $this->query($sql);
	    }
	    else {
	    	$sql = "INSERT INTO #_user (steamid, ".$column.")
	        VALUES ('$steamid', '$data')";
	        $result = $this->query($sql);
	    }
    }

    public function echoUserInfo($steamid, $column, $lang=false, $team_num=false)
    {
    	$registered = $this->query("SELECT ".$column." FROM #_user WHERE steamid = '".$steamid."'");
		$tableRow = mysqli_fetch_assoc( $registered );
		
		
		
		if ($column == "cs_go" || $column == "dota") {
			if ($tableRow[$column] >= 1) {
		        echo $tableRow[$column];
		    } else {
		    	echo "1";
		    }
		} elseif ($lang) {
			if ($lang == $tableRow[$column]) {
				echo "selected";
			}
		} elseif ($team_num) {
			if ($tableRow[$column] == $team_num) {
				echo "selected";
			} else {
				echo "wtf";
			}
		} else {
			if ($tableRow[$column] >= 1) {
		        echo $tableRow[$column];
		    } else {
		    	echo "Type...";
		    }
		}
    }

    /**
     * Selects only one value
     */

    public function echoUserData($column, $table, $filter_col, $filter_value)
    {
    	$result = $this->query("SELECT ".$column." FROM `".$table."` WHERE ".$filter_col." = '".$filter_value."'");
		$value = mysqli_fetch_assoc( $result );
	    
	    if(isset($value['name'])){
	        $value['name'] = htmlspecialchars_decode( $value['name']) ;
	    }
		
		return $value[$column];
    }

    public function delRankPref($rank)
    {
    	$rank = str_replace("rank_", "", $rank);
    	return $rank;
    }


	/**
	 * Update the last login in checkin time
	 * WHERE dt<SUBTIME(NOW(),'0 0:10:0')
	 */
	public function updateLastVisit($steamid) {
		$sql = "UPDATE `#_user` 
			SET `last_active` = NOW()
			WHERE `steamid` = '".$steamid."'";
		$result = $this->query($sql);
	}

	public function sbLeftChat($hash='')
	{
		$sql = "SELECT `hash` 
			FROM `#_dialog`
			WHERE `hash` = '".$hash."';";
		$result = $this->query($sql);
		$hashRow = mysqli_fetch_assoc( $result );
		if ($hashRow>0) {
			return true;
		} else {
			return false;
		}
	}

	public function clearAfterChat($userid)
	{
		$fsd = $this->getRows("SELECT utd.dialogid,dg.hash 
		FROM `#_dialog` AS dg LEFT JOIN `#_user_to_dialog` AS utd ON dg.id=utd.dialogid  
		WHERE utd.userid ='".$userid."'");
		foreach($fsd as $dg){
			$this->id = $dg['dialogid'];
			$this->hash = $dg['hash'];
			if (isset($this->id)) {
				$this->query("DELETE FROM `#_dialog` 
				WHERE id ='".$this->id."'");
				$this->query("DELETE FROM `#_user_to_dialog` 
				WHERE dialogid ='".$this->id."'");
				$this->query("DELETE FROM `#_message` 
				WHERE dialogid ='".$this->id."'");
				$this->query("DELETE FROM `#_message_to_user` 
				WHERE userid ='".$userid."'");
			}
		}
	}

	private function _arrayKeysToSet($values){
		 $ret='';
		  if( is_array($values) ){
			foreach($values as $key=>$value){
			  if(!empty($ret))$ret.=',';
			  $ret.="`$key`='".$this->escape($value)."'";
			}
		  }else $ret=$values;
		  return $ret;
	}
	private function error(){
		$langcharset = 'utf-8';
		echo "<HTML>\n";
		echo "<HEAD>\n";
		echo "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=".$langcharset."\">\n";
		echo "<TITLE>MySQL Debugging</TITLE>\n";
		echo "</HEAD>\n";
		echo "<div style=\"border:1px dotted #000000; font-size:11px; font-family:tahoma,verdana,arial; background-color:#f3f3f3; color:#A73C3C; margin:5px; padding:5px;\">";
		echo "<b><font style=\"color:#666666;\">MySQL Debugging</font></b><br /><br />";
		echo "<li><b>SQL.q :</b> <font style=\"color:#666666;\">".$this->sql."</font></li>";
		//echo "<li><b>MySQL.e :</b> <font style=\"color:#666666;\">".mysqli_error($this->connid)."</font></li>";
		//echo "<li><b>MySQL.e.№ :</b> <font style=\"color:#666666;\">".mysqli_errno($this->connid)."</font></li>";
		echo "<li><b>PHP.v :</b> <font style=\"color:#666666;\">".phpversion()."\n</font></li>";
		echo "<li><b>Data :</b> <font style=\"color:#666666;\">".date("d.m.Y H:i")."\n</font></li>";
		echo "<li><b>Script :</b> <font style=\"color:#666666;\">".getenv("REQUEST_URI")."</font></li>";
		echo "<li><b>Refer :</b> <font style=\"color:#666666;\">".getenv("HTTP_REFERER")."</li></div>";
		echo "</BODY>\n";
		echo "</HTML>";
		exit();
	}
}