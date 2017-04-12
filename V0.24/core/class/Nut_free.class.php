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

		$Nut_freeCmd = $this->getCmd(null, 'Model');
		if (!is_object($Nut_freeCmd)) {
			$Nut_freeCmd = new Nut_freeCmd();
			$Nut_freeCmd->setLogicalId('Model');
			$Nut_freeCmd->setIsVisible(1);
			$Nut_freeCmd->setName(__('Marque_Model', __FILE__));
			$Nut_freeCmd->setOrder(1);
			$Nut_freeCmd->setTemplate('dashboard', 'line');
		}
			$Nut_freeCmd->setType('info');
			$Nut_freeCmd->setSubType('string');
			$Nut_freeCmd->setEqLogic_id($this->getId());
			$Nut_freeCmd->save();
		
		$Nut_freeCmd = $this->getCmd(null, 'ups_line');
		if (!is_object($Nut_freeCmd)) {
			$Nut_freeCmd = new Nut_freeCmd();
		}
			$Nut_freeCmd->setName(__('UPS MODE',  __FILE__));
			$Nut_freeCmd->setEqLogic_id($this->getId());
			$Nut_freeCmd->setLogicalId('ups_line');
			$Nut_freeCmd->setType('info');
			$Nut_freeCmd->setSubType('string');
			$Nut_freeCmd->save();		
	
		$Nut_freeCmd = $this->getCmd(null, 'input_volt');
		if (!is_object($Nut_freeCmd)) {
			$Nut_freeCmd = new Nut_freeCmd();
		}
			$Nut_freeCmd->setName(__('Tension en entrée',  __FILE__));
			$Nut_freeCmd->setEqLogic_id($this->getId());
			$Nut_freeCmd->setLogicalId('input_volt');
			$Nut_freeCmd->setType('info');
			$Nut_freeCmd->setSubType('numeric');
			$Nut_freeCmd->save();		
		
		
			
		$Nut_freeCmd = $this->getCmd(null, 'input_freq');
		if (!is_object($Nut_freeCmd)) {
			$Nut_freeCmd = new Nut_freeCmd();
		}
			$Nut_freeCmd->setName(__('Fréquence en entrée', __FILE__));
			$Nut_freeCmd->setEqLogic_id($this->getId());
			$Nut_freeCmd->setLogicalId('input_freq');
			$Nut_freeCmd->setType('info');
			$Nut_freeCmd->setSubType('numeric');
			$Nut_freeCmd->save();
		
		$Nut_freeCmd = $this->getCmd(null, 'output_volt');
		if (!is_object($Nut_freeCmd)) {
			$Nut_freeCmd = new Nut_freeCmd();
		}
			$Nut_freeCmd->setName(__('Tension en sortie',  __FILE__));
			$Nut_freeCmd->setEqLogic_id($this->getId());
			$Nut_freeCmd->setLogicalId('output_volt');
			$Nut_freeCmd->setType('info');
			$Nut_freeCmd->setSubType('numeric');
			$Nut_freeCmd->save();		
		
		
			
		$Nut_freeCmd = $this->getCmd(null, 'output_freq');
		if (!is_object($Nut_freeCmd)) {
			$Nut_freeCmd = new Nut_freeCmd();
		}
			$Nut_freeCmd->setName(__('Fréquence en sortie', __FILE__));
			$Nut_freeCmd->setEqLogic_id($this->getId());
			$Nut_freeCmd->setLogicalId('output_freq');
			$Nut_freeCmd->setType('info');
			$Nut_freeCmd->setSubType('numeric');
			$Nut_freeCmd->save();
		
		$Nut_freeCmd = $this->getCmd(null, 'output_power');
		if (!is_object($Nut_freeCmd)) {
			$Nut_freeCmd = new Nut_freeCmd();
		}
			$Nut_freeCmd->setName(__('Puissance en sortie', __FILE__));
			$Nut_freeCmd->setEqLogic_id($this->getId());
			$Nut_freeCmd->setLogicalId('output_power');
			$Nut_freeCmd->setType('info');
			$Nut_freeCmd->setSubType('numeric');
			$Nut_freeCmd->save();
		
		$Nut_freeCmd = $this->getCmd(null, 'batt_charge');
		if (!is_object($Nut_freeCmd)) {
			$Nut_freeCmd = new Nut_freeCmd();
		}
			$Nut_freeCmd->setName(__('Niveau de charge batterie', __FILE__));
			$Nut_freeCmd->setEqLogic_id($this->getId());
			$Nut_freeCmd->setLogicalId('batt_charge');
			$Nut_freeCmd->setType('info');
			$Nut_freeCmd->setSubType('numeric');
			$Nut_freeCmd->save();
			
		$Nut_freeCmd = $this->getCmd(null, 'batt_volt');
		if (!is_object($Nut_freeCmd)) {
			$Nut_freeCmd = new Nut_freeCmd();
		}
			$Nut_freeCmd->setName(__('Tension de la batterie', __FILE__));
			$Nut_freeCmd->setEqLogic_id($this->getId());
			$Nut_freeCmd->setLogicalId('batt_volt');
			$Nut_freeCmd->setType('info');
			$Nut_freeCmd->setSubType('numeric');
			$Nut_freeCmd->save();
			
		$Nut_freeCmd = $this->getCmd(null, 'ups_load');
		if (!is_object($Nut_freeCmd)) {
			$Nut_freeCmd = new Nut_freeCmd();
		}
			$Nut_freeCmd->setName(__('Charge onduleur', __FILE__));
			$Nut_freeCmd->setEqLogic_id($this->getId());
			$Nut_freeCmd->setLogicalId('ups_load');
			$Nut_freeCmd->setType('info');
			$Nut_freeCmd->setSubType('numeric');
			$Nut_freeCmd->save();
		
		$Nut_freeCmd = $this->getCmd(null, 'batt_runtime');
		if (!is_object($Nut_freeCmd)) {
			$Nut_freeCmd = new Nut_freeCmd();
		}
			$Nut_freeCmd->setName(__('Temps restant sur batterie', __FILE__));
			$Nut_freeCmd->setEqLogic_id($this->getId());
			$Nut_freeCmd->setLogicalId('batt_runtime');
			$Nut_freeCmd->setType('info');
			$Nut_freeCmd->setSubType('numeric');
			$Nut_freeCmd->save();
			
		$Nut_freeCmd = $this->getCmd(null, 'timer_shutdown');
		if (!is_object($Nut_freeCmd)) {
			$Nut_freeCmd = new Nut_freeCmd();
		}
			$Nut_freeCmd->setName(__('Temps restant avant arrêt', __FILE__));
			$Nut_freeCmd->setEqLogic_id($this->getId());
			$Nut_freeCmd->setLogicalId('timer_shutdown');
			$Nut_freeCmd->setType('info');
			$Nut_freeCmd->setSubType('numeric');
			$Nut_freeCmd->save();
		
		$Nut_freeCmd = $this->getCmd(null, 'ssh_op');
		if (!is_object($Nut_freeCmd)) {
			$Nut_freeCmd = new Nut_freeCmd();
		}
			$Nut_freeCmd->setName(__('SSH OPTION', __FILE__));
			$Nut_freeCmd->setEqLogic_id($this->getId());
			$Nut_freeCmd->setLogicalId('ssh_op');
			$Nut_freeCmd->setConfiguration('data', 'ssh_op');
			$Nut_freeCmd->setType('info');
			$Nut_freeCmd->setSubType('numeric');
			$Nut_freeCmd->save();
		
		
		
		$Nut_freeCmd = $this->getCmd(null, 'cnx_ssh');
		if (!is_object($Nut_freeCmd)) {
			$Nut_freeCmd = new Nut_freeCmd();
		}
			$Nut_freeCmd->setName(__('Statut cnx SSH Scénario', __FILE__));
			$Nut_freeCmd->setEqLogic_id($this->getId());
			$Nut_freeCmd->setLogicalId('cnx_ssh');
			$Nut_freeCmd->setType('info');
			$Nut_freeCmd->setSubType('string');
			$Nut_freeCmd->save();
			
		foreach (eqLogic::byType('Nut_free') as $Nut_free) {
			$Nut_free->getInformations();
		}
	}
	

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

 	public function toHtml($_version = 'dashboard')	{
		$replace = $this->preToHtml($_version);
		if (!is_array($replace)) {
			return $replace;
		}
		$_version = jeedom::versionAlias($_version);

		
		$Model = $this->getCmd(null,'Model');
		$replace['#Model#'] = (is_object($Model)) ? $Model->execCmd() : '';
		$replace['#Modelid#'] = is_object($Model) ? $Model->getId() : '';
		$replace['#Model_display#'] = (is_object($Model) && $Model->getIsVisible()) ? "#Model_display#" : "none";
		
		$ups_line = $this->getCmd(null,'ups_line');
		$replace['#ups_line#'] = (is_object($ups_line)) ? $ups_line->execCmd() : '';
		$replace['#ups_lineid#'] = is_object($ups_line) ? $ups_line->getId() : '';
		$replace['#ups_line_display#'] = (is_object($ups_line) && $ups_line->getIsVisible()) ? "#ups_line_display#" : "none";

		$input_volt = $this->getCmd(null,'input_volt');
		$replace['#input_volt#'] = (is_object($input_volt)) ? $input_volt->execCmd() : '';
		$replace['#input_voltid#'] = is_object($input_volt) ? $input_volt->getId() : '';
		$replace['#input_volt_display#'] = (is_object($input_volt) && $input_volt->getIsVisible()) ? "#input_volt_display#" : "none";
		
		$input_freq = $this->getCmd(null,'input_freq');
		$replace['#input_freq#'] = (is_object($input_freq)) ? $input_freq->execCmd() : '';
		$replace['#input_freqid#'] = is_object($input_freq) ? $input_freq->getId() : '';
		$replace['#input_freq_display#'] = (is_object($input_freq) && $input_freq->getIsVisible()) ? "#input_freq_display#" : "none";
		
		$output_volt = $this->getCmd(null,'output_volt');
		$replace['#output_volt#'] = (is_object($output_volt)) ? $output_volt->execCmd() : '';
		$replace['#output_voltid#'] = is_object($output_volt) ? $output_volt->getId() : '';
		$replace['#output_volt_display#'] = (is_object($output_volt) && $output_volt->getIsVisible()) ? "#output_volt_display#" : "none";
		
		$output_freq = $this->getCmd(null,'output_freq');
		$replace['#output_freq#'] = (is_object($output_freq)) ? $output_freq->execCmd() : '';
		$replace['#output_freqid#'] = is_object($output_freq) ? $output_freq->getId() : '';
		$replace['#output_freq_display#'] = (is_object($output_freq) && $output_freq->getIsVisible()) ? "#output_freq_display#" : "none";
		
		$output_power = $this->getCmd(null,'output_power');
		$replace['#output_power#'] = (is_object($output_power)) ? $output_power->execCmd() : '';
		$replace['#output_powerid#'] = is_object($output_power) ? $output_power->getId() : '';
		$replace['#output_power_display#'] = (is_object($output_power) && $output_power->getIsVisible()) ? "#output_power_display#" : "none";
		
		$batt_charge = $this->getCmd(null,'batt_charge');
		$replace['#batt_charge#'] = (is_object($batt_charge)) ? $batt_charge->execCmd() : '';
		$replace['#batt_chargeid#'] = is_object($batt_charge) ? $batt_charge->getId() : '';
		$replace['#batt_charge_display#'] = (is_object($batt_charge) && $batt_charge->getIsVisible()) ? "#batt_charge_display#" : "none";
		
		$batt_volt = $this->getCmd(null,'batt_volt');
		$replace['#batt_volt#'] = (is_object($batt_volt)) ? $batt_volt->execCmd() : '';
		$replace['#batt_voltid#'] = is_object($batt_volt) ? $batt_volt->getId() : '';
		$replace['#batt_volt_display#'] = (is_object($batt_volt) && $batt_volt->getIsVisible()) ? "#batt_volt_display#" : "none";
		
		$ups_load = $this->getCmd(null,'ups_load');
		$replace['#ups_load#'] = (is_object($ups_load)) ? $ups_load->execCmd() : '';
		$replace['#ups_loadid#'] = is_object($ups_load) ? $ups_load->getId() : '';
		$replace['#ups_load_display#'] = (is_object($ups_load) && $ups_load->getIsVisible()) ? "#ups_load_display#" : "none";
		
		$batt_runtime = $this->getCmd(null,'batt_runtime');
		$replace['#batt_runtime#'] = (is_object($batt_runtime)) ? $batt_runtime->execCmd() : '';
		$replace['#batt_runtimeid#'] = is_object($batt_runtime) ? $batt_runtime->getId() : '';
		$replace['#batt_runtime_display#'] = (is_object($batt_runtime) && $batt_runtime->getIsVisible()) ? "#batt_runtime_display#" : "none";
		
		
		$timer_shutdown = $this->getCmd(null,'timer_shutdown');
		$replace['#timer_shutdown#'] = (is_object($timer_shutdown)) ? $timer_shutdown->execCmd() : '';
		$replace['#timer_shutdownid#'] = is_object($timer_shutdown) ? $timer_shutdown->getId() : '';
		$replace['#timer_shutdown_display#'] = (is_object($timer_shutdown) && $timer_shutdown->getIsVisible()) ? "#timer_shutdown_display#" : "none";
		
		$ssh_op = $this->getCmd(null,'ssh_op');
		$replace['#ssh_op#'] = (is_object($ssh_op)) ? $ssh_op->execCmd() : '';
		$replace['#ssh_opid#'] = is_object($ssh_op) ? $ssh_op->getId() : '';
		
		$cnx_ssh = $this->getCmd(null,'cnx_ssh');
		$replace['#cnx_ssh#'] = (is_object($cnx_ssh)) ? $cnx_ssh->execCmd() : '';
		$replace['#cnx_sshid#'] = is_object($cnx_ssh) ? $cnx_ssh->getId() : '';
		
			
		foreach ($this->getCmd('action') as $cmd) {
			$replace['#cmd_' . $cmd->getLogicalId() . '_id#'] = $cmd->getId();
		}

		$html = template_replace($replace, getTemplate('core', $_version, 'Nut_free','Nut_free'));
		cache::set('Nut_freeWidget' . $_version . $this->getId(), $html, 0);
		return $html;
	}

   public function getInformations() {
		
		
		if ($this->getIsEnable()){
			$ip = $this->getConfiguration('addressip');
			$UPS_auto_select = $this->getConfiguration('UPS_auto_select');
			$ups = $this->getConfiguration('UPS');
			$ssh_op = $this->getConfiguration('SSH_select');
			$equipement = $this->getName();
			$ups_debug = $this->getConfiguration('UPS');		
		}
		
		
		////////////////////////////////////////
		//			SANS Connexion SSH   	  //
		////////////////////////////////////////
		if ($ssh_op == '0'){
			$upscmd="upsc -l ".$ip."  > /dev/stdout 2> /dev/null";
			$ups_auto=exec ($upscmd);
			
			if (($ups=='')&&($ssh_op == '0')){
				
				$ups = $ups_auto;
			}
			
				$cnx_ssh = 'OK';
				$Marque_infocmd = "upsc ".$ups."@".$ip." device.mfr  > /dev/stdout 2> /dev/null";
				$Modelcmd = "upsc ".$ups."@".$ip." device.model  > /dev/stdout 2> /dev/null";
				$ups_linecmd= "upsc ".$ups."@".$ip." ups.status  > /dev/stdout 2> /dev/null";
				$input_voltcmd = "upsc ".$ups."@".$ip." input.voltage  > /dev/stdout 2> /dev/null";
				$input_freqcmd = "upsc ".$ups."@".$ip." input.frequency  > /dev/stdout 2> /dev/null";
				$output_voltcmd = "upsc ".$ups."@".$ip." output.voltage  > /dev/stdout 2> /dev/null";
				$output_freqcmd = "upsc ".$ups."@".$ip." output.frequency  > /dev/stdout 2> /dev/null";
				$output_powercmd = "upsc ".$ups."@".$ip." ups.power > /dev/stdout 2> /dev/null";
				$batt_chargecmd = "upsc ".$ups."@".$ip." battery.charge > /dev/stdout 2> /dev/null";
				$batt_voltcmd = "upsc ".$ups."@".$ip." battery.voltage > /dev/stdout 2> /dev/null";
				$timer_shutdowncmd = "upsc ".$ups."@".$ip." ups.timer.shutdown > /dev/stdout 2> /dev/null";
				$ups_loadcmd = "upsc ".$ups."@".$ip." ups.load > /dev/stdout 2> /dev/null";
				$batt_runtimecmd = "upsc ".$ups."@".$ip." battery.runtime > /dev/stdout 2> /dev/null";
			
										
					/* Listing des commandes*/
					
					/* Action*/
					
					$Marque_info = exec($Marque_infocmd);
					$Model = exec( $Modelcmd); 
					$ups_line = exec($ups_linecmd);
					$input_volt = exec($input_voltcmd);
					$input_freq = exec($input_freqcmd);
					$output_volt = exec($output_voltcmd);
					$output_freq = exec($output_freqcmd);
					$output_power = exec($output_powercmd);
					$batt_charge = exec($batt_chargecmd);
					$batt_volt = exec($batt_voltcmd);
					$batt_runtime = exec($batt_runtimecmd);	
					$timer_shutdown = exec($timer_shutdowncmd);
					$ups_load = exec($ups_loadcmd);
					$Model= $Marque_info." ".$Model;
					//$Model= $ups_line;
			}
			
			////////////////////////////////////////
			//			AVEC Connexion SSH   	  //
			////////////////////////////////////////
			if ($ssh_op == '1'){
						
				
			$user = $this->getConfiguration('user');
			$pass = $this->getConfiguration('password');
			$port = $this->getConfiguration('portssh');
			
				
				if (!$connection = ssh2_connect($ip,$port)){
					log::add('Nut_free', 'error', 'connexion SSH KO pour '.$equipement);
					$cnx_ssh = 'KO';
				}else{
					if (!ssh2_auth_password($connection,$user,$pass)){
					log::add('Nut_free', 'error', 'Authentification SSH KO pour '.$equipement);
					$cnx_ssh = 'KO';
					}else{
						
						$upscmd = "upsc -l";

						$ups_output = ssh2_exec($connection, $upscmd); 
						stream_set_blocking($ups_output, true);
						$ups_auto = stream_get_contents($ups_output);
						fclose($ups_output); 
						$ups_auto = substr($ups_auto, 0, -1);
						
						if ($ups==''){
							$ups = $ups_auto;
						}
												
						$cnx_ssh = 'OK';
						
						
											
						/* Listing des commandes*/
						$Marque_infocmd = "upsc ".$ups." device.mfr";
						$Modelcmd = "upsc ".$ups." device.model";
						$ups_linecmd = "upsc ".$ups." ups.status";
						$input_voltcmd = "upsc ".$ups." input.voltage";
						$input_freqcmd = "upsc ".$ups." input.frequency";
						$output_voltcmd = "upsc ".$ups." output.voltage";
						$output_freqcmd = "upsc ".$ups." output.frequency";
						$output_powercmd = "upsc ".$ups." ups.power";
						$batt_chargecmd = "upsc ".$ups." battery.charge";
						$batt_voltcmd = "upsc ".$ups." battery.voltage";
						$ups_loadcmd = "upsc ".$ups." ups.load";
						$batt_runtimecmd = "upsc ".$ups." battery.runtime";
						$timer_shutdowncmd = "upsc ".$ups." ups.timer.shutdown";
						
									
						/* Action*/
						
						$Marque_infooutput = ssh2_exec($connection, $Marque_infocmd); 
						stream_set_blocking($Marque_infooutput, true);
						$Marque_info = stream_get_contents($Marque_infooutput);
						fclose($Marque_infooutput);
						
						$Modeloutput = ssh2_exec($connection, $Modelcmd); 
						stream_set_blocking($Modeloutput, true);
						$Model = stream_get_contents($Modeloutput);	
						fclose($Modeloutput);
						
						$ups_lineoutput = ssh2_exec($connection, $ups_linecmd); 
						stream_set_blocking($ups_lineoutput, true);
						$ups_line = stream_get_contents($ups_lineoutput);
						fclose($ups_lineoutput);
							
						$input_voltoutput = ssh2_exec($connection, $input_voltcmd); 
						stream_set_blocking($input_voltoutput, true);
						$input_volt = stream_get_contents($input_voltoutput);
						fclose($input_voltoutput);
	
						$input_freqoutput = ssh2_exec($connection, $input_freqcmd); 
						stream_set_blocking($input_freqoutput, true);
						$input_freq = stream_get_contents($input_freqoutput);
						fclose($input_freqoutput);
						
						$output_voltoutput = ssh2_exec($connection, $output_voltcmd); 
						stream_set_blocking($output_voltoutput, true);
						$output_volt = stream_get_contents($output_voltoutput);
						fclose($output_voltoutput);
						
						$output_freqoutput = ssh2_exec($connection, $output_freqcmd); 
						stream_set_blocking($output_freqoutput, true);
						$output_freq = stream_get_contents($output_freqoutput);
						fclose($output_freqoutput);
							
						$output_poweroutput = ssh2_exec($connection, $output_powercmd); 
						stream_set_blocking($output_poweroutput, true);
						$output_power = stream_get_contents($output_poweroutput);
						fclose($output_poweroutput);
							
						$batt_chargeoutput = ssh2_exec($connection, $batt_chargecmd); 
						stream_set_blocking($batt_chargeoutput, true);
						$batt_charge = stream_get_contents($batt_chargeoutput);
						fclose($batt_chargeoutput);	
						
						$batt_voltoutput = ssh2_exec($connection, $batt_voltcmd); 
						stream_set_blocking($batt_voltoutput, true);
						$batt_volt = stream_get_contents($batt_voltoutput);
						fclose($batt_voltoutput);
										
						$ups_loadoutput = ssh2_exec($connection, $ups_loadcmd); 
						stream_set_blocking($ups_loadoutput, true);
						$ups_load = stream_get_contents($ups_loadoutput);
						fclose($ups_loadoutput);
						
						$batt_runtimeoutput = ssh2_exec($connection, $batt_runtimecmd); 
						stream_set_blocking($batt_runtimeoutput, true);
						$batt_runtime = stream_get_contents($batt_runtimeoutput);
						fclose($batt_runtimeoutput);
						
						$timer_shutdownoutput = ssh2_exec($connection, $timer_shutdowncmd); 
						stream_set_blocking($timer_shutdownoutput, true);
						$timer_shutdown = stream_get_contents($timer_shutdownoutput);
						fclose($timer_shutdownoutput);
						
						$connection = ssh2_connect($ip,$port);
						ssh2_auth_password($connection,$user,$pass);

						$closesession = ssh2_exec($connection, 'exit'); 
						stream_set_blocking($closesession, true);
						stream_get_contents($closesession);
						//close ssh ($connection);
												
						$Model= $Marque_info." ".$Model;
						//$Model= $timer_shutdown;
						
						
					}
				}
			}
		
		/*DEBUG général*/
		if ($this->getIsEnable()){		
			log::add('Nut_free', 'debug',' -----------------------------------------------------' );
			log::add('Nut_free', 'debug', $equipement.' UPS auto select: ' . $UPS_auto_select );
			log::add('Nut_free', 'debug', $equipement.' UPS configured: ' . $ups_debug );
			log::add('Nut_free', 'debug', $equipement.' UPS auto detect: '. $ups_auto);
			log::add('Nut_free', 'debug', $equipement.' UPS commande pour auto_detect: '. $upscmd);
			log::add('Nut_free', 'debug', $equipement.' UPS Connexion type: '. $ssh_op);
		}	
				
		if (isset($cnx_ssh)) {

				if (empty($cnx_ssh)) {$cnx_ssh = '';}
							
				$dataresult = array(
					'Model' => $Model,
					'ups_line' => $ups_line,
					'input_volt' => $input_volt,
					'input_freq' => $input_freq,
					'output_volt' => $output_volt,
					'output_freq' => $output_freq,
					'output_power' => $output_power,
					'batt_charge' => $batt_charge,
					'batt_volt' => $batt_volt,
					'ups_load' => $ups_load,
					'batt_runtime' => $batt_runtime, 
					'timer_shutdown' => $timer_shutdown, 
					'ssh_op' => $ssh_op,
					'cnx_ssh' => $cnx_ssh,
				);
					
				$Model = $this->getCmd(null,'Model');
					if(is_object($Model)){
						$Model->event($dataresult['Model']);
					}
				$ups_line = $this->getCmd(null,'ups_line');
					if(is_object($ups_line)){
						$ups_line->event($dataresult['ups_line']);
					}
				$input_volt = $this->getCmd(null,'input_volt');
					if(is_object($input_volt)){
						$input_volt->event($dataresult['input_volt']);
					}
				$input_freq = $this->getCmd(null,'input_freq');
					if(is_object($input_freq)){
						$input_freq->event($dataresult['input_freq']);
					}
				$output_volt = $this->getCmd(null,'output_volt');
					if(is_object($output_volt)){
						$output_volt->event($dataresult['output_volt']);
					}
				$output_freq = $this->getCmd(null,'output_freq');
					if(is_object($output_freq)){
						$output_freq->event($dataresult['output_freq']);
					}
				$output_power = $this->getCmd(null,'output_power');
					if(is_object($output_power)){
						$output_power->event($dataresult['output_power']);
					}
				$batt_charge = $this->getCmd(null,'batt_charge');
					if(is_object($batt_charge)){
						$batt_charge->event($dataresult['batt_charge']);
					}
				$batt_volt = $this->getCmd(null,'batt_volt');
				if(is_object($batt_volt)){
					$batt_volt->event($dataresult['batt_volt']);
					}
				$ups_load = $this->getCmd(null,'ups_load');
					if(is_object($ups_load)){
						$ups_load->event($dataresult['ups_load']);
					}
				$batt_runtime = $this->getCmd(null,'batt_runtime');
				if(is_object($batt_runtime)){
					$batt_runtime->event($dataresult['batt_runtime']);
				} 
				
				$timer_shutdown = $this->getCmd(null,'timer_shutdown');
				if(is_object($timer_shutdown)){
					$timer_shutdown->event($dataresult['timer_shutdown']);
				} 
					
				$ssh_op = $this->getCmd(null,'ssh_op');
					if(is_object($ssh_op)){
						$ssh_op->event($dataresult['ssh_op']);
					}	
				$cnx_ssh = $this->getCmd(null,'cnx_ssh');
					if(is_object($cnx_ssh)){
						$cnx_ssh->event($dataresult['cnx_ssh']);
					}				
			}
		
		if (isset($cnx_ssh)) {
			if($cnx_ssh == 'KO'){
				$dataresult = array(
					'Model' => 'Connexion SSH KO',
					'cnx_ssh' => $cnx_ssh
				);
				$Model = $this->getCmd(null,'Model');
					if(is_object($Model)){
						$Model->event($dataresult['Model']);
					}
				$cnx_ssh = $this->getCmd(null,'cnx_ssh');
					if(is_object($cnx_ssh)){
						$cnx_ssh->event($dataresult['cnx_ssh']);
					}
			}
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
