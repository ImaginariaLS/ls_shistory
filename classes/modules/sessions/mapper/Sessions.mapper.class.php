<?php

class PluginSHistory_ModuleSessions_MapperSessions extends Mapper {

	function isCurrent($user_id, $session_key) {
	
		$sql = "SELECT `id` FROM ".Config::Get('db.table.shistory')."
					WHERE 
				`user_id` = ? 
				AND 
				`session_key` = ?
			";
						
		if ( $aRow=$this->oDb->selectRow( $sql, $user_id, $session_key ) )
			return true; 
		else return false;
		
	}
	
	function addCurrent($user_id, $session_key, $date, $time, $os, $browser, $ip) {
	
		$sql = "SELECT COUNT( * ) as cnt FROM ".Config::Get('db.table.shistory')." WHERE `user_id` = ?";
		if( $sCnt = $this->oDb->selectRow( $sql , $user_id ) ) {
			if( $sCnt['cnt'] >= Config::Get('shistoryLimit') ) {
				$this->oDb->query( "DELETE FROM ".Config::Get('db.table.shistory')." WHERE `user_id` = ? ORDER BY id LIMIT 1", $user_id );
			}
		}

		$sql = "
			INSERT INTO `".Config::Get('db.table.shistory')."`
				(
					`user_id`,
					`enter_date`,
					`enter_time`,
					`session_key`,
					`user_ip`,
					`user_os`,
					`user_agent`
				)
					VALUES 
				(
					?,?,?,?,?,?,?
				)
			";
		return $this->oDb->query( $sql, $user_id, $date, $time, $session_key, $ip, $os, $browser );
		
	}
	
	function getHistoryRows( $user_id ) {
	
		$sql = "SELECT 
					`enter_date`,
					`enter_time`,
					`user_ip`,
					`user_os`,
					`user_agent`
				FROM ".Config::Get('db.table.shistory')."
				WHERE
					`user_id` = ? 
				ORDER BY id DESC
				LIMIT ".Config::Get('shistoryLimit')."
			";
		$aReturn = array();
		if ($aRows = $this->oDb->select( $sql, $user_id )) {
			foreach($aRows as $aRow)
				$aReturn[] = $aRow;
		}
		return $aReturn;
		
	}
}

?>
