<?php
class teamSearchEng{
	private $time_active = 10; // seconds
	private $user_table = '#_user';
	private $user_id_field = 'steamid';
	private $user_active_field = 'last_active';
	private $user_team_num_field = 'team_num';
	function __construct( $db, $steamid ){
		$this->db = $db;
		$this->steamid = $steamid;
	} 

	/**
	  * This sql checks if the user is online now, maybe not so important
	  * Because we have is searching `cs_go_st` = 'yes'
	$sql = "SELECT `".$this->user_id_field."` 
				FROM `".$this->user_table."`
				WHERE `".$this->user_active_field."`>SUBTIME(NOW(),'0 0:0:".$this->time_active."')
				AND `cs_go_st` = 'yes'
				AND `".$this->user_team_num_field."` = '".$tableRow[$this->user_team_num_field]."'
				AND (`cs_go` BETWEEN ".$min_rank." AND ".$max_rank.")
				AND NOT ".$this->user_id_field." = '".$this->steamid."';";
	 */


	public function searchTeam($game)
	{
	    

		if ($game == 'cs_go') {
			$rank = $this->db->query("SELECT `".$game."` FROM `".$this->user_table."` WHERE `".$this->user_id_field."` = '".$this->steamid."'");
			
			$tableRow = mysqli_fetch_assoc( $rank );
			
			$min_rank = $tableRow[$game]-3;
			$max_rank = $tableRow[$game]+3;
			$team_num = $this->db->query("SELECT `".$this->user_team_num_field."` FROM `".$this->user_table."` WHERE `".$this->user_id_field."` = '".$this->steamid."'");
			$tableRow = mysqli_fetch_assoc( $team_num );
			$sql = "SELECT `".$this->user_id_field."` 
				FROM `".$this->user_table."`
				WHERE `cs_go_st` = 'yes'
				AND `".$this->user_team_num_field."` = '".$tableRow[$this->user_team_num_field]."'
				AND (`cs_go` BETWEEN ".$min_rank." AND ".$max_rank.")
				AND NOT ".$this->user_id_field." = '".$this->steamid."'
				AND NOT `dota_st` = 'in_chat';";
			$result = $this->db->query($sql);
			$mateRow = mysqli_fetch_assoc( $result );
// 			var_dump($mateRow);
			if ($mateRow>0) {
				$team_mate = array();
				$num = 0;
				$team_mate[$num] = $mateRow['steamid'];
				while ( $mateRow = mysqli_fetch_assoc( $result ) ) {
					$num++;
					$team_mate[$num] = $mateRow['steamid'];
				}
				if ($tableRow[$this->user_team_num_field] == 2) {
					if (count($team_mate) > 0) {
						$last_mate = count($team_mate) - 1;
						$mate_num = rand(0,$last_mate);
					} elseif (count($team_mate)==0) {
						$mate_num = 0; 
					}
					
				// 	echo $team_mate[$mate_num];
					
				// 	echo $this->steamid;
					$this->db->saveUserData($team_mate[$mate_num], "cs_go_st", "in_chat");
					$this->db->saveUserData($this->steamid, "cs_go_st", "in_chat");
					return $team_mate[$mate_num];
					
				} elseif ($tableRow[$this->user_team_num_field] == 5) {
					if (count($team_mate) >= 4) {
						$last_mate = count($team_mate) - 1;
						$mate_num_1 = rand(0,$last_mate);
						do {   
						    $mate_num_2 = rand(0,$last_mate);
						} while(in_array($mate_num_2, array($mate_num_1)));
						do {   
						    $mate_num_3 = rand(0,$last_mate);
						} while(in_array($mate_num_3, array($mate_num_1, $mate_num_2)));
						do {   
						    $mate_num_4 = rand(0,$last_mate);
						} while(in_array($n, array($mate_num_1, $mate_num_2, $mate_num_3)));
						$team_mates = array(
							'mate_1' => $team_mate[$mate_num_1], 
							'mate_2' => $team_mate[$mate_num_2], 
							'mate_3' => $team_mate[$mate_num_3], 
							'mate_4' => $team_mate[$mate_num_4]
						);
						$this->db->saveUserData($this->steamid, "cs_go_st", "in_chat");
						$this->db->saveUserData($team_mate[$mate_num_1], "cs_go_st", "in_chat");
						$this->db->saveUserData($team_mate[$mate_num_2], "cs_go_st", "in_chat");
						$this->db->saveUserData($team_mate[$mate_num_3], "cs_go_st", "in_chat");
						$this->db->saveUserData($team_mate[$mate_num_4], "cs_go_st", "in_chat");
						return $team_mates;
					} elseif (count($team_mate)==0) {
						return 0;
					} 
					
				}
			} elseif (!$result) {
				return false;
			}
			
		} elseif ($game == 'dota') {
			$mmr = $this->db->query("SELECT `".$game."` FROM `".$this->user_table."` WHERE `".$this->user_id_field."` = '".$this->steamid."'");
			$tableRow = mysqli_fetch_assoc( $mmr );
			$min_mmr = $tableRow[$game]-1000;
			$max_mmr = $tableRow[$game]+1000;
			$team_num = $this->db->query("SELECT `".$this->user_team_num_field."` FROM `".$this->user_table."` WHERE `".$this->user_id_field."` = '".$this->steamid."'");
			$tableRow = mysqli_fetch_assoc( $team_num );
			$sql = "SELECT `".$this->user_id_field."` 
				FROM `".$this->user_table."`
				WHERE `dota_st` = 'yes'
				AND `".$this->user_team_num_field."` = '".$tableRow[$this->user_team_num_field]."'
				AND (`cs_go` BETWEEN ".$min_mmr." AND ".$max_mmr.")
				AND NOT ".$this->user_id_field." = '".$this->steamid."'
				AND NOT `cs_go_st` = 'in_chat';;";
			$result = $this->db->query($sql);
			$mateRow = mysqli_fetch_assoc( $result );
			if ($mateRow>0) {
				$team_mate = array();
				$num = 0;
				$team_mate[$num] = $mateRow['steamid'];
				while ( $mateRow = mysqli_fetch_assoc( $result ) ) {
					$num++;
					$team_mate[$num] = $mateRow['steamid'];
				}
				if ($tableRow[$this->user_team_num_field] == 2) {
					if (count($team_mate) > 0) {
						$last_mate = count($team_mate) - 1;
						$mate_num = rand(0,$last_mate);
					} elseif (count($team_mate)==0) {
						$mate_num = 0;
					}
					$this->db->saveUserData($team_mate[$mate_num], "dota_st", "in_chat");
					$this->db->saveUserData($this->steamid, "dota_st", "in_chat");
					return $team_mate[$mate_num];
				} elseif ($tableRow[$this->user_team_num_field] == 5) {
					if (count($team_mate) >= 4) {
						$last_mate = count($team_mate) - 1;
						$mate_num_1 = rand(0,$last_mate);
						do {   
						    $mate_num_2 = rand(0,$last_mate);
						} while(in_array($mate_num_2, array($mate_num_1)));
						do {   
						    $mate_num_3 = rand(0,$last_mate);
						} while(in_array($mate_num_3, array($mate_num_1, $mate_num_2)));
						do {   
						    $mate_num_4 = rand(0,$last_mate);
						} while(in_array($n, array($mate_num_1, $mate_num_2, $mate_num_3)));
						$team_mates = array(
							'mate_1' => $team_mate[$mate_num_1], 
							'mate_2' => $team_mate[$mate_num_2], 
							'mate_3' => $team_mate[$mate_num_3], 
							'mate_4' => $team_mate[$mate_num_4]
						);
						$this->db->saveUserData($this->steamid, "dota_st", "in_chat");
						$this->db->saveUserData($team_mate[$mate_num_1], "dota_st", "in_chat");
						$this->db->saveUserData($team_mate[$mate_num_2], "dota_st", "in_chat");
						$this->db->saveUserData($team_mate[$mate_num_3], "dota_st", "in_chat");
						$this->db->saveUserData($team_mate[$mate_num_4], "dota_st", "in_chat");
						return $team_mates;
					} elseif (count($team_mate)==0) {
						return 0;
					} 
					
				}
			} elseif (!$result) {
				return false;
			}
		}
	}
}