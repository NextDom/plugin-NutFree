<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; witfhout even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *f
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

					
class Nut_free extends eqLogic {
	
	public static $_infosMap = array(
		//on cree un tableau contenant la liste des infos a traiter 
		//chaque info a un sous tableau avec les parametres 
		// dans postSave() il faut le parcourir pour creer les cmd
// 		array(
// 			'name' =>'Nom de l\'equipement infol'
// 			'logicalId'=>'Id de l\'quipement',
// 			'type'=>'info', //on peu ne  pas specifie cette valeur et alors dans la boucle mettre celle par default
// 			'subType'=>'string', //idem
// 			'order' => 1, // ici on pourrai utiliser l'index du tableau et l'ordre serait le meme que ce tableau
// 			'template_dashboard'=> 'line'
//			'cmd' => 'ups.status', //commande a executer
// 		),
	
		array(
			'name' =>'Marque_Model',
			'logicalId'=>'Marque',
			'template_dashboard'=> 'line',
			'subtype'=>'string',
			'cmd'=>'device.mfr',
		),
		array(
			'name' =>'Model',
			'logicalId'=>'Model',
			'subtype'=>'string',
			'cmd'=>'device.model',
		),
		array(
			'name' =>'UPS MODE',
			'logicalId'=>'ups_line',
			'cmd' => 'ups.status',
			'subtype'=>'string',
		),
		array(
			'name' =>'Tension en entrée',
			'logicalId'=>'input_volt',
			'cmd'=>'input.voltage',
			'unite'=>'V',
		),
		array(
			'name' =>'Fréquence en entrée',
			'logicalId'=>'input_freq',
			'cmd'=>'input.frequency',
			'unite'=>'Hz',
		),
		array(
			'name' =>'Tension en sortie',
			'logicalId'=>'output_volt',
			'cmd'=>'output.voltage',
			'unite'=>'V',
		),
		array(
			'name' =>'Fréquence en sortie',
			'logicalId'=>'output_freq',
			'cmd'=>'output.frequency',
			'unite'=>'Hz',
		),
		array(
			'name' =>'Puissance en sortie',
			'logicalId'=>'output_power',
			'cmd'=>'ups.power',
			'unite'=>'W',
		),
		array(
			'name' =>'Niveau de charge batterie',
			'logicalId'=>'batt_charge',
			'cmd'=>'battery.charge',
			'unite'=>'%',
		),
		array(
			'name' =>'Tension de la batterie',
			'logicalId'=>'batt_volt',
			'cmd'=>'battery.voltage',
			'subtype'=>'string',
			'unite'=>'V',
		),
		array(
			'name' =>'Charge onduleur',
			'logicalId'=>'ups_load',
			'cmd'=>'ups.load',
			'unite'=>'%',
		),
		array(
			'name' =>'Temps restant sur batterie',
			'logicalId'=>'batt_runtime',
			'cmd'=>'battery.runtime',
			'unite'=>'s',
		),
		array(
			'name' =>'Temps restant avant arrêt',
			'logicalId'=>'timer_shutdown',
			'cmd'=>'ups.timer.shutdown',
			'unite'=>'s',
		),
		array(
			'name' =>'SSH OPTION',
			'logicalId'=>'ssh_op',
		),
		array(
			'name' =>'Statut cnx SSH Scénario',
			'logicalId'=>'cnx_ssh',
			'subtype'=>'string',
		),
	);

    public static function cron() {
		foreach (eqLogic::byType('Nut_free') as $Nut_free) {
			$Nut_free->getInformations();
			$mc = cache::byKey('Nut_freeWidgetmobile' . $Nut_free->getId());
			$mc->remove();
			$mc = cache::byKey('Nut_freeWidgetdashboard' . $Nut_free->getId());
			$mc->remove();
			$Nut_free->toHtml('mobile');
			$Nut_free->toHtml('dashboard');
			$Nut_free->refreshWidget();
		}
	}

	
	public static function dependancy_info() {
		$return = array();
		$return['log'] = 'Nut_free_update';
		$return['progress_file'] = '/tmp/dependancy_Nut_free_in_progress';
		if (file_exists('/tmp/dependancy_Nut_free_in_progress')) {
			$return['state'] = 'in_progress';
		} else {
			if (exec('dpkg-query -l nut-client | wc -l') != 0) {
				$return['state'] = 'ok';
			} else {
				$return['state'] = 'nok';
			}
		}
		return $return;
	}

	public static function dependancy_install() {
		if (file_exists('/tmp/compilation_Nut_free_in_progress')) {
			return;
		}
		log::remove('Nut_free_update');
		$cmd = 'sudo /bin/bash ' . dirname(__FILE__) . '/../../ressources/install.sh';
		$cmd .= ' >> ' . log::getPathToLog('Nut_free_update') . ' 2>&1 &';
		exec($cmd);
	}	

	public function postSave() {
				
		$idx = 0;
		//parcours du tableau $idx contient l'index commencant a 0 et $info contien le sous tableau de  parametres l'info
		foreach(self::$_infosMap as $idx=>$info)
		{
			$Nut_freeCmd = $this->getCmd(null, $info['logicalId']);//on recupere nos valeur
			if (!is_object($Nut_freeCmd)) {
				$Nut_freeCmd = new Nut_freeCmd();
				$Nut_freeCmd->setLogicalId( $info['logicalId']);
				$Nut_freeCmd->setName(__( $info['name'], __FILE__));
				$Nut_freeCmd->setOrder($idx+1); //+1 car $idx commence a 0
				if(isset($info['template_dashboard'])) //on verifi si on a specifier une template, si oui on l'affecte, on peu creer une autre cle $info['template_mobile'] si bessoin
					$Nut_freeCmd->setTemplate('dashboard', $info['template_dashboard']);
			}
			
			$Nut_freeCmd->setType($params['type'] ?: 'info'); //ici comparaison unitaire, si le parametre est specifiÃ© on l'utilise sinon on met notre default
			
				//$Nut_freeCmd->setSubType($params['subtype'] ?: 'string');
			if(isset($info['subtype'])){ //on verifi si on a specifier une template, si oui on l'affecte, on peu creer une autre cle $info['template_mobile'] si bessoin
					$Nut_freeCmd->setSubType($info['subtype']);
			}else{
				$Nut_freeCmd->setSubType('numeric', $info['subtype']);
			}
			if(isset($info[unite])){
				$Nut_freeCmd->setUnite($info['unite']);
			}
			
			if(isset($info['isVisible']))
			$Nut_freeCmd->setIsVisible($params['isVisible']);
			$Nut_freeCmd->setEqLogic_id($this->getId());
			//sur le meme model tu peux ajouter d'autres parametre qu'il faudrait changer par info
			
			$Nut_freeCmd->save();
		}
			$this->getInformations();
	}
	
/*
	public static $_widgetPossibility = array('custom' => array(
      'visibility' => true,
      'displayName' => true,
      'displayObjectName' => true,
      'optionalParameters' => false,
      'background-color' => true,
      'text-color' => true,
      'border' => true,
      'border-radius' => true,
      'background-opacity' => true,
	));
*/
 	public function toHtml($_version = 'dashboard')	{
		$replace = $this->preToHtml($_version);
		if (!is_array($replace)) {
			return $replace;
		}
		$version = jeedom::versionAlias($_version);
		$cmd_html = '';
		$br_before = 0;
		
		foreach(self::$_infosMap as $idx=>$info)
		{
			$cmd = $this->getCmd(null,$info['logicalId']);
			$replace['#'.$info['logicalId'].'#'] = (is_object($cmd)) ? $cmd->execCmd() : '';
			$replace['#'.$info['logicalId'].'id#'] = is_object($cmd) ? $cmd->getId() : '';
			$replace['#'.$info['logicalId'].'_display#'] = (is_object($cmd) && $cmd->getIsVisible()) ? '#'.$info['logicalId'].'_display#' : "none";
		}
		////////////////////////////////////////////////////////////////////
		foreach ($this->getCmd(null, null, true) as $cmd) {
			if (isset($replace['#refresh_id#']) && $cmd->getId() == $replace['#refresh_id#']) {
				continue;
			}
			if ($br_before == 0 && $cmd->getDisplay('forceReturnLineBefore', 0) == 1) {
				$cmd_html .= '<br/>';
			}
			$cmd_html .= $cmd->toHtml($_version, '', $replace['#cmd-background-color#']);
			$br_before = 0;
			if ($cmd->getDisplay('forceReturnLineAfter', 0) == 1) {
				$cmd_html .= '<br/>';
				$br_before = 1;
			}
		}
		
		
		///////////////////////////////////////////////////////////////////
		/*
		/////////////////////////////////////////////////////////////
		//('action')
		foreach ($this->getCmd('action') as $cmd) {
			$replace['#cmd_' . $cmd->getLogicalId() . '_id#'] = $cmd->getId();
		}
		////////////////////////////////////////////////////////////////
		*/
		$html = template_replace($replace, getTemplate('core', $version, 'Nut_free','Nut_free'));
		//cache::set('Nut_freeWidget' . $_version . $this->getId(), $html, 0);
		
		return $html;
	}
	/*
	public function toHtml($_version = 'dashboard') {
		$replace = $this->preToHtml($_version);
		if (!is_array($replace)) {
			return $replace;
		}
		$version = jeedom::versionAlias($_version);
		$cmd_html = '';
		$br_before = 0;
		foreach ($this->getCmd(null, null, true) as $cmd) {
			if (isset($replace['#refresh_id#']) && $cmd->getId() == $replace['#refresh_id#']) {
				continue;
			}
			if ($br_before == 0 && $cmd->getDisplay('forceReturnLineBefore', 0) == 1) {
				$cmd_html .= '<br/>';
			}
			$cmd_html .= $cmd->toHtml($_version, '', $replace['#cmd-background-color#']);
			$br_before = 0;
			if ($cmd->getDisplay('forceReturnLineAfter', 0) == 1) {
				$cmd_html .= '<br/>';
				$br_before = 1;
			}
		}
		$replace['#cmd#'] = $cmd_html;
		return template_replace($replace, getTemplate('core', $version, 'worxLandroid', 'worxLandroid'));
	}
	*/
   public function getInformations() {
		
		//ici tu pourrais sortir direcetement si l'eqp n'est pas actif -> 
		if (!$this->getIsEnable()) return;
		
		if ($this->getIsEnable()){ 
			$ip = $this->getConfiguration('addressip');
			$UPS_auto_select = $this->getConfiguration('UPS_auto_select');
			$ups = $this->getConfiguration('UPS');
			$ssh_op = $this->getConfiguration('SSH_select');
			$equipement = $this->getName();
			$ups_debug = $this->getConfiguration('UPS');		
		}
		
		//initialisation du mode deporter ou pass
		$cnx_ssh = 'KO';
		
		if ($ssh_op == '0')
		{
			$upscmd="upsc -l ".$ip."  > /dev/stdout 2> /dev/null";
			$ups_auto=exec ($upscmd);
			
			if (($ups=='')&&($ssh_op == '0')){
				
				$ups = $ups_auto;
			}
			
			$cnx_ssh = 'OK';
		}elseif ($ssh_op == '1'){
			$user = $this->getConfiguration('user');
			$pass = $this->getConfiguration('password');
			$port = $this->getConfiguration('portssh');
			
			if (!$sshconnection = ssh2_connect($ip,$port)){
				log::add('Nut_free', 'error', 'connexion SSH KO pour ' . $equipement );
				$cnx_ssh = 'KO';
			}else{
				if (!ssh2_auth_password($sshconnection,$user,$pass)){
				log::add('Nut_free', 'error', 'Authentification SSH KO pour ' . $equipement );
				$cnx_ssh = 'KO';
				}else{
					
					$upscmd = "upsc -l";
					$ups_output = ssh2_exec($sshconnection, $upscmd); 
					stream_set_blocking($ups_output, true);
					$ups_auto = stream_get_contents($ups_output);
					fclose($ups_output); 
					$ups_auto = substr($ups_auto, 0, -1);
					
					if ($ups==''){
						$ups = $ups_auto;
					}
					$cnx_ssh = 'OK';
				}
			}
		}
		
		$cmd = $this->getCmd(null,'cnx_ssh');
		if(is_object($cmd)){
			$cmd->event($cnx_ssh);
		}
		
		$cmd = $this->getCmd(null,'ssh_op');
		if(is_object($cmd)){
			$cmd->event($ssh_op);
		}
		if($cnx_ssh != 'OK')
			return false; // on sort car on a pas de connexion
		
		// ici il faut boucler sur notre tableau et execuer les commande pour mettre a jour les infos
		log::add('Nut_free', 'debug',' -----------------------------------------------------' );
		foreach(self::$_infosMap as $idx=>$info)
		{
			if(isset($info['cmd'])) //verifie que l'on a une cmd a executer
			{
				if ($ssh_op == '0')
				{
					$errorresult="";
					/* 2>&1 permet de recuperer l'erreur et la traiter */
					$cmdline = "upsc ".$ups."@".$ip." ".$info['cmd']." 2>&1";
					$result = exec($cmdline);
					if (strstr($result,'not supported by UPS')){
						$errorresult=$result;
					}

				}else{
					$cmdline = "upsc ".$ups."@".$ip." ".$info['cmd'];
					
					$resultoutput = ssh2_exec($sshconnection, $cmdline); 
					stream_set_blocking($resultoutput, true);
					stream_set_blocking($errorStream, true);
					$result =stream_get_contents($resultoutput);
					$errorStream = ssh2_fetch_stream($resultoutput, SSH2_STREAM_STDERR);
					$errorresult = stream_get_contents($errorStream);
					fclose($resultoutput);
				}
				/*Affichage sur une ligne Marque / Model*/
				if ($idx==0){
					$Marque = $result;
				}
				if ($idx==1){
					$result = $Marque.' '.$result;
				}
				/*Log pour debug */
				if (!strstr($errorresult,'not supported by UPS')){
					log::add('Nut_free', 'debug', $equipement.' UPS '.$info['name'].' : '. $result);
				}else{
					log::add('Nut_free', 'debug', $equipement.' UPS '.$info['name'].' : '.$errorresult);
					
					/*Désactivation de la commande si retour d'erreur*/
					$cmd = $this->getCmd(null,$info['logicalId']);
					$cmd->setIsVisible(0);
					$cmd->setEqLogic_id($this->getId());
					$cmd->save();
				}
				
				//met a jour l'info ds jeedom
				$cmd = $this->getCmd(null,$info['logicalId']);
				if(is_object($cmd)){
					$cmd->event($result);
					
				}
				
			}

		}
		log::add('Nut_free', 'debug',' -----------------------------------------------------' );
	
		
		/*DEBUG général*/
		if ($this->getIsEnable()){		
			log::add('Nut_free', 'debug',' -----------------------------------------------------' );
			log::add('Nut_free', 'debug', $equipement.' UPS auto select: ' . $UPS_auto_select );
			log::add('Nut_free', 'debug', $equipement.' UPS configured: ' . $ups_debug );
			log::add('Nut_free', 'debug', $equipement.' UPS auto detect: '. $ups_auto);
			log::add('Nut_free', 'debug', $equipement.' UPS commande pour auto_detect: '. $upscmd);
			log::add('Nut_free', 'debug', $equipement.' UPS Connexion type: '. $ssh_op);
			log::add('Nut_free', 'debug',' -----------------------------------------------------' );
		}				
		
	}
	
	function getCaseAction($paramaction) {
		

			$ip = $this->getConfiguration('addressip');
			$UPS_auto_select= $this->getConfiguration('UPS_auto_select');
			$user = $this->getConfiguration('user');
			$pass = $this->getConfiguration('password');
			$port = $this->getConfiguration('portssh');
			$ups = $this->getConfiguration('ups');
			$equipement = $this->getName();
		
			if (!$connection = ssh2_connect($ip,$port)) {
				log::add('Nut_free', 'error', 'connexion SSH KO pour '.$equipement);
				$cnx_ssh = 'KO';
			}else{
				if (!ssh2_auth_password($connection,$user,$pass)){
				log::add('Nut_free', 'error', 'Authentification SSH KO pour '.$equipement);
				$cnx_ssh = 'KO';
				}else{
					
				}
			}
	}
}

class Nut_freeCmd extends cmd {


/*     * *************************Attributs****************************** */
	public static $_widgetPossibility = array('custom' => false);
	
/*     * *********************Methode d'instance************************* */
	public function execute($_options = null) {
		$eqLogic = $this->getEqLogic();
		$paramaction = $this->getLogicalId();

		if ( $this->GetType = "action" ) {
			$eqLogic->getCmd();
			$contentCmd = $eqLogic->getCaseAction($paramaction);
		} else {
            throw new Exception(__('Commande non implémentée actuellement', __FILE__));
		}
        return true;
	}
}

?>
