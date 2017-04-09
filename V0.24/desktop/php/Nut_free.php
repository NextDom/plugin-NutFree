<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

global $listCmdNut_free;

sendVarToJS('eqType', 'Nut_free');

$eqLogics = eqLogic::byType('Nut_free');

?>

<div class="row row-overflow">
	<div class="col-lg-2">
		<div class="bs-sidebar">
			<ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
				<a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter un Nut_free}}</a>
				<li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
				<?php
				foreach ($eqLogics as $eqLogic) {
					echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
				}
				?>
			</ul>
		</div>
	</div>
 <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
   <legend><i class="fa fa-cog"></i>  {{Gestion}}</legend>
   <div class="eqLogicThumbnailContainer">
    <div class="cursor eqLogicAction" data-action="add" style="background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
     <center>
      <i class="fa fa-plus-circle" style="font-size : 5em;color:#94ca02;"></i>
    </center>
    <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02"><center>Ajouter</center></span>
  </div>
  <div class="cursor eqLogicAction" data-action="gotoPluginConf" style="background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
    <center>
      <i class="fa fa-wrench" style="font-size : 5em;color:#767676;"></i>
    </center>
    <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676"><center>{{Configuration}}</center></span>
  </div>
</div>
	<legend><i class="fa fa-table"></i> {{Mes Nut_frees}}</legend>
<div class="eqLogicThumbnailContainer">
		 <?php
				foreach ($eqLogics as $eqLogic) {
					echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >';
					echo "<center>";
					echo '<img src="plugins/Nut_free/doc/images/Nut_free_icon.png" height="105" width="95" />';
					echo "</center>";
					echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' . $eqLogic->getHumanName(true, true) . '</center></span>';
					echo '</div>';
				}
				?>
		</div>
	</div>
<div class="col-md-10 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
  <a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
  <a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>

  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-tachometer"></i> {{Equipement}}</a></li>
    <li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Commandes}}</a></li>
</ul>


<div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
    <div role="tabpanel" class="tab-pane active" id="eqlogictab">
        <div>
            <div>
		<form class="form-horizontal">
			<fieldset>
				<legend><i class="fa fa-arrow-circle-left eqLogicAction cursor" data-action="returnToThumbnailDisplay"></i> {{Général}}<i class='fa fa-cogs eqLogicAction pull-right cursor expertModeVisible' data-action='configure'></i></legend>
				<div class="form-group">
					<label class="col-lg-2 control-label">{{Nom de l'équipement Nut_free}}</label>
					<div class="col-lg-3">
						<input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
						<input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement Nut_free}}"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label" >{{Objet parent}}</label>
					<div class="col-lg-3">
						<select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
							<option value="">{{Aucun}}</option>
							<?php
							foreach (object::all() as $object) {
								echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
							}
							?>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-lg-2 control-label">{{Catégorie}}</label>
					<div class="col-lg-5">
						<?php
						foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
							echo '<label class="checkbox-inline">';
							echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
							echo '</label>';
						}
						?>
					</div>
				</div>
				 <div class="form-group">
                <label class="col-md-3 control-label" ></label>
                <div class="col-md-9">
                 <input type="checkbox" class="eqLogicAttr bootstrapSwitch" data-label-text="{{Activer}}" data-l1key="isEnable" checked/>
                  <input type="checkbox" class="eqLogicAttr bootstrapSwitch" data-label-text="{{Visible}}" data-l1key="isVisible" checked/>
                </div>
                </div>
							
				<div id="Conf_IP">
				   <div class="form-group">
					  <label class="col-md-2 control-label">{{Adresse IP}}</label>   
					  <div class="col-md-3">
						 <input class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="addressip" type="text" placeholder="{{saisir l'adresse IP}}">
					  </div>
				   </div>
					
					<div class="form-group">
					  <label class="col-md-2 control-label">{{Nom de la configuration UPS}}</label>   
					  <div class="col-md-3">
						 <input class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="UPS" type="text" placeholder="{{saisir le nom de l'UPS du serveur. &quot;Resultat de UPSC -L&quot; sur le serveur UPS }}">
					  </div>
				   </div> 
					
					<div class="form-group">
				   <label class="col-md-2 control-label">{{Avec Connexion SSH?}}</label>
				   <div class="col-md-3">
					 <select id="SSH_select" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="SSH_select"
					  onchange="if(this.selectedIndex == 1) document.getElementById('SSH_op').style.display = 'block';
					  else document.getElementById('SSH_op').style.display = 'none';">
						 <option value="0">{{Non}}</option>
						 <option value="1">{{Oui}}</option>
					  </select>
					  
				   </div>
				</div>
				  
					  <div id="SSH_op">
					  
					   <div class="form-group">
						  <label class="col-md-2 control-label">{{Port SSH}}</label>   
						  <div class="col-md-3">
							 <input class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="portssh" type="text" placeholder="{{saisir le port SSH}}">
						  </div>
					   </div>
					   <div class="form-group">
						  <label class="col-md-2 control-label">{{Identifiant}}</label>   
						  <div class="col-md-3">
							 <input class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="user" type="text" placeholder="{{saisir le login}}">
						  </div>
					   </div>   
					   <div class="form-group">
						  <label class="col-md-2 control-label">{{Mot de passe}}</label>   
						  <div class="col-md-3">
							 <input class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="password" type="password" placeholder="{{saisir le password}}">
						  </div>
					   </div>         
					</div>
				
				</div>
				
						
				
			</fieldset>
		</form>
		       </div>

   </div>

</div>
<div role="tabpanel" class="tab-pane" id="commandtab">		
		<legend><i class="fa fa-arrow-circle-left"></i> {{Commandes}}</legend>		
		<table id="table_cmd" class="table table-bordered table-condensed">
			<thead>
				<tr>
					<th>{{Id}}</th>
					<th>{{Nom}}</th>
					<th>{{Colorisation des valeurs}}</th>
					<th>{{Afficher/Historiser}}</th>
					<th>{{Action}}</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>

		<form class="form-horizontal">
			<fieldset>
				<div class="form-actions">
					<a class="btn btn-danger eqLogicAction" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
					<a class="btn btn-success eqLogicAction" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
				</div>
			</fieldset>
		</form>
	</div>
</div>
</div>
</div>
<?php include_file('desktop', 'Nut_free', 'js', 'Nut_free'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>
