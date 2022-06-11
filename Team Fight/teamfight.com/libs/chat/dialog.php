<?php
class dialog{
  public $utime = 0;
	public $userid = 0;
	public $err = '';
	public $hash = '';
	public $id = '';
	private $user_table = 'user';
	private $user_id_field = 'id';
	private $user_image_field = 'image';
	function __construct( $db,$utime,$userid,$hash = ''){
		$this->db = $db;
		$this->utime = $utime;
		$this->userid = $userid;
		$this->err = '';
		$this->hash = $hash;
		$this->exists() or $this->hash='' ;
	}
	function exists(){
		return ($this->hash and $this->id = $this->db->exists('dialog',$this->db->escape($this->hash),'hash','','id')) ;
	}	
	function _genhash ($length = 8){
		$password = "";
		$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
		$maxlength = strlen($possible);
		if ($length > $maxlength) {
			$length = $maxlength;
		}
		$i = 0; 
		while ($i < $length) { 
			$char = substr($possible, mt_rand(0, $maxlength-1), 1);
			if (!strstr($password, $char)) { 
				$password .= $char;
				$i++;
			}
		}
		return $password;
	}
	private function _trim($text){
		return preg_replace( array('#^[\s\n\r]+#u','#[\s\n\r]+$#u'),'',$text );
	}
	private function _ekran( $text ){
		$text = strip_tags($text);
		$text = nl2br($text);
		$this->images = array();
		preg_match_all('#\[img\]([^\]]*)\[/img\]#Uusi',$text,$images);
		$text = preg_replace_callback('#\[img\]([^\]]*)\[/img\]#Uusi',function($match){
			return md5($match[0]);
		},$text);
		$text = preg_replace(array('#(http://[^$\s\r]+)($|[\s\r\n])#Uusi'),array('<a target="_blank" rel="nofollow" href="$1">$1</a>$2'),$text);
		foreach($images[0] as $k=>$tx){
			$text = str_replace(md5($tx),'<img src="'.$images[1][$k].'"/>',$text);
		}
		return $this->_trim($text);
	}
	private function create(){
		$res = 0;
		do{
			$this->hash = $this->_genhash();
		}while($this->db->exists('dialog',$this->hash,'hash'));
		$this->db->insert('dialog',array('public'=>$this->utime,'hash'=>$this->hash,'userid'=>$this->userid));
		$this->id = $this->db->insertid();
		return true;
	}

	public function ret_hash(){
		return $this->hash;
	}
	
	public function find_suit_dialog($userlist = array()){
		if( !$this->id and (!$this->hash or !($this->id = $this->db->exists('dialog',$this->db->escape($this->hash),'hash','','id'))) ){
			if( count($userlist)==1 ){
				$dlgs = $this->db->getRows('select count(utd.userid) as cnt,utd.dialogid,dg.hash from #_user_to_dialog as utd left join #_dialog as dg on dg.id=utd.dialogid  where utd.dialogid in (select dialogid from #_user_to_dialog where  userid='.intval($userlist[0]).' and dialogid in(select dialogid from #_user_to_dialog where userid='.$this->userid.')) group by utd.dialogid;');
				foreach($dlgs as $dg){
					if( $dg['cnt']==2 ){
						$this->id = $dg['dialogid'];
						$this->hash = $dg['hash'];
						break;
					}
				}
			}
			if( !$this->id ){
				$this->create();
			}
		};
		return $this->err=='';
	}

	public function user_was_found($userid){
		// in(select userid from #_user_to_dialog where userid='".$userid."')
		$fsd = $this->db->getRows("select dg.hash,utd.dialogid 
		from #_dialog as dg left join #_user_to_dialog as utd on dg.id=utd.dialogid  
		where utd.userid ='".$userid."'");
		foreach ($fsd as $data) {
			$hash = $data['hash'];
			if ($hash != '' && $hash != '1') {
				$this->hash = $hash;
				return true;
				break;
			} else {
				return false;
				break;
			}
		}
		
	}

	public function take_user_img($userid)
	{
		$fsd = $this->db->getRows("SELECT dialogid 
		FROM #_user_to_dialog 
		WHERE userid ='".$userid."'");
		foreach ($fsd as $data) {
			$dialogid = $data['dialogid'];
			if ($dialogid != '' && $dialogid != '1') {
				$num = 0;
				$mate_id = array();
				$mates = $this->db->query("SELECT userid 
				FROM #_user_to_dialog 
				WHERE dialogid ='".$dialogid."'
				AND NOT userid ='".$userid."'");
				while ( $mateRow = mysqli_fetch_assoc( $mates ) ) {
					$mate_id[$num] = $mateRow['userid'];
					$num++;
				}
				if ($num == 1) {
					$team_mates = array(
							'mate_1' => $mate_id[0], 
							'num' => 1
						);
					return $team_mates;
				} elseif ($num == 3) {
					$team_mates = array(
							'mate_1' => $mate_id[0], 
							'mate_2' => $mate_id[1], 
							'mate_3' => $mate_id[2], 
							'mate_4' => $mate_id[3],
							'num' => 4 
						);
					return $team_mates;
				} else {
					return false;
				}
				break;
			} else {
				return false;
				break;
			}
		}
	}

	function get_messages( $new=false ){
		$cnt = $this->get_new_messages_cnt();
		$messages = (!$cnt&&$new)?array():$this->get_messages_from_dialog($new);
		$out = '';
		$mess_owner = 'mess';
		
		foreach($messages as $msg)
			if ($msg['senderid'] == $this->userid) {
				$mess_owner = 'personal_mess';
				$out.='
				<div class="clearfix">
					<div class="mess_general '.$mess_owner.'">
						<span class="message_time">'.date('H:i',$msg['public']).'</span>
						<div>'.$msg['message'].'</div>
					</div>
					<div class="clearex"></div>
				</div>';
			} else {
				$out.='
				<div class="clearfix">
					<div class="mess_general '.$mess_owner.'">
						<span class="nickname">
							<a href="http://steamcommunity.com/profiles/'.$this->db->echoUserData("steamid", "#_user", "id", $msg['senderid']).'/" id="user_'.$msg['senderid'].'" target="_blank">'.$msg['sender_name'].'</a>
							<div>'.$msg['message'].'</div>
						</span>
						<span class="message_time">'.date('H:i',$msg['public']).'</span>
					</div>
					<div class="clearex"></div>
				</div>';
			}
		return array('html'=>$out,'cnt'=>$cnt,'res'=>'0');
		// date('H:i:s d/m/Y',$msg['public'])
	}

	function get_new_messages_cnt(){
		$cnt = $this->db->getRow('select count(id) as cnt from #_message_to_user where userid='.$this->userid.' and status=0');
		return $cnt['cnt'];
	}
	function get_users_from_dialog(){
		$users = $this->db->getRows('select userid from #_user_to_dialog where dialogid = '.$this->id,'userid');
		return $users;
	}
	function get_user_dialogs( $start=0,$cnt = 10 ){
		$sql = ' from #_message as msg left join #_'.$this->user_table.' as user on user.'.$this->user_id_field.'=msg.senderid left join #_dialog as dg on dg.id=msg.dialogid left join #_message_to_user as m2u on (m2u.messageid=msg.id and m2u.userid='.$this->userid.') where msg.dialogid in (select id from #_dialog where id in (select dialogid from #_user_to_dialog where userid='.$this->userid.')) ';
		$messages = $this->db->getRows('select * from(select dg.hash,msg.*,user.name as sender_name,user.'.$this->user_image_field.' as sender_image, m2u.status as msg_status '.$sql.' order by msg.dialogid desc,msg.public desc) as bg group by bg.dialogid  limit '.$start.','.$cnt);
		return $messages;
	}
	function get_messages_from_dialog($new=false,$reset_status = true){
		$messages = array(); $filter = !$new?'':' mtu.status=0 and ';
		if( $this->id or ($this->hash and $this->id = $this->db->exists('dialog',$this->db->escape($this->hash),'hash','','id')) ){
			$sql = ' from #_message as msg left join #_'.$this->user_table.' as user on user.'.$this->user_id_field.'=msg.senderid  left join #_message_to_user as mtu on mtu.userid='.$this->userid.' and mtu.messageid=msg.id where '.$filter.' msg.dialogid='.$this->id.' and msg.dialogid in (select id from #_dialog where id in (select dialogid from #_user_to_dialog where userid='.$this->userid.')) ';
			$full_cnt = $this->db->getRow('select count(msg.id) as cnt '.$sql.' group by msg.dialogid','cnt');//order by msg.dialogid desc,msg.public desc
			$messages = $this->db->getRows('select mtu.status, msg.*,user.name as sender_name,user.'.$this->user_image_field.' as sender_image '.$sql.' order by msg.public asc');
			foreach($messages as $key=>$msg)
				$reset_status and $this->db->update('message_to_user',array('status'=>1),'messageid ='.$msg['id'].' and userid='.$this->userid);
		}else
			$this->err = 'Диалог не найден';
		return $messages;
	}
	function remove_users_from_dialog( $userlist = array() ){
		if( $this->id or ($this->hash and isset($userlist) and is_array($userlist) and $this->id = $this->db->exists('dialog',$this->db->escape($this->hash),'hash',' and userid = '.$this->userid,'id')) ){
			foreach($userlist as $userid){
				if( intval($userid)!=$this->userid ){
					if($this->db->exists('user_to_dialog',intval($userid),'userid','and dialogid='.$this->id)){
						if(($this->db->getRow('select count(id) as cnt from #_user_to_dialog where userid<>'.$this->userid.' and dialogid='.$this->id,'cnt'))>1){
							$this->db->delete('user_to_dialog','userid='.intval($userid).' and dialogid='.$this->id);
						}else{ $this->err = 'В диалоге должен быть по крайней мере один пользователь';	break; }
					}
				}else{
					$this->err = 'Вы не можете удалить себя из своего диалога';	
					break; 
				}
			}
		}else 
			$this->err = 'Диалог не найден';
		return $this->err=='';
	}
	function add_users_to_dialog( $userlist = array() ){
		if( $this->id or ($this->hash and isset($userlist) and is_array($userlist) and $this->id = $this->db->exists('dialog',$this->db->escape($this->hash),'hash','and userid = '.$this->userid,'id')) ){
			foreach($userlist as $userid){
				if($this->db->exists('user_to_dialog',intval($userid),'userid','and dialogid='.$this->id))continue; // если пользователь уже в диалоге
				$this->db->insert('user_to_dialog',array('dialogid'=>$this->id,'userid'=>intval($userid)));
			}
		}else
			$this->err = 'Диалог не найден';
		return $this->err=='';
	}
	function send($msg,$intro = false){
		$this->send_many_users($msg,$this->get_users_from_dialog(),$intro);
	}
	function send_many_users( $msg,$userlist,$intro = false ){
		$message = !$intro?$this->_ekran($msg):$msg;
		if( mb_strlen($message)>0 ){
			$this->find_suit_dialog($userlist);
			if($this->db->exists('user_to_dialog',$this->userid,'userid','and dialogid='.$this->id)){
				$this->db->insert('message',array('senderid'=>$this->userid,'message'=>$message,'public'=>$this->utime,'status'=>0,'dialogid'=>$this->id));
				$messageid = $this->db->insertid();
				if( isset($val['attaches'])and(is_array($val['attaches'])) ){
					foreach($val['attaches'] as $attach){
						if($this->db->exists('attach',$attach)){
							$this->db->insert('attach_to_message',array('messageid'=>$messageid,'attachid'=>$attach));
						}
					}
				}
				$users = $this->db->getRows('select userid from #_user_to_dialog where dialogid='.$this->id); // под вопросом, нужно ли добавлять отправителю сообщение
				foreach($users as $user){
					$this->db->insert('message_to_user',array('messageid'=>$messageid,'userid'=>$user['userid'])); // для опопвещения юзера о непрочитанных сообщениях
				}
			}else
				$this->err =  'Вы не можете участвовать в данном диалоге';
		}else
			$this->err  = 'Слишком короткое сообщение';
		return $this->err=='';
	}
	public function delete_message( $messageid ){
		if( intval($messageid) and $id=$this->db->exists('message',intval($messageid))){
			$cnt = $this->db->getRow('select count(id) as cnt from #_message where id='.intval($messageid).' and (senderid='.$this->userid.' or id in (select messageid from #_message_to_user where userid='.$this->userid.'))','cnt');
			if($cnt){
				$this->db->delete('message','id='.intval($messageid));
				$this->db->delete('message_to_user','messageid='.intval($messageid));
			}else $this->err = 'Не найдено ни одного сообщения!';
		}else  $this->err = 'Не найдено ни одного сообщения!';
		return $this->err=='';
	}
}
