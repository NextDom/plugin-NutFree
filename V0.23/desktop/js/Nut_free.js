
/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

function addCmdToTable(_cmd) {
	if (!isset(_cmd)) {
		var _cmd = {configuration: {}};
	}
	var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
	tr += '<td>';
	tr += '<span class="cmdAttr" data-l1key="id" ></span>';
	tr += '</td>';
	tr += '<td>';
	tr += '<input class="cmdAttr form-control input-sm" data-l1key="type" value="info" style="display: none">';
	tr += '<input class="cmdAttr form-control input-sm" data-l1key="name"">';
	tr += '</td>'; 
	tr += '<td>';
	tr += '</td>';
	tr += '<td style="width: 150px;">';
	if (_cmd.logicalId == 'Model' || _cmd.logicalId == 'ups_line' ||_cmd.logicalId == 'input_volt' || _cmd.logicalId == 'input_freq'|| _cmd.logicalId == 'output_volt' || _cmd.logicalId == 'output_freq'||_cmd.logicalId == 'output_power'||_cmd.logicalId == 'batt_charge'||_cmd.logicalId == 'batt_volt'||_cmd.logicalId == 'ups_load'||_cmd.logicalId == 'batt_runtime'||_cmd.logicalId == 'timer_shutdown') {
		tr += '<span><input type="checkbox" class="cmdAttr" data-size="mini" data-l1key="isVisible" checked/> {{Afficher}}<br/></span>';
	}
	if (_cmd.logicalId == 'input_volt' ||_cmd.logicalId == 'input_freq'||_cmd.logicalId == 'output_volt' ||_cmd.logicalId == 'output_freq'||_cmd.logicalId == 'output_power'||_cmd.logicalId == 'batt_charge'||_cmd.logicalId == 'batt_volt'||_cmd.logicalId == 'ups_load'||_cmd.logicalId == 'batt_runtime'||_cmd.logicalId == 'timer_shutdown') {
		tr += '<span><input type="checkbox" class="cmdAttr" data-l1key="isHistorized"/> {{Historiser}}</span>';
	}
	tr += '</td>';
		tr += '<td>';
	if (is_numeric(_cmd.id)) {
		tr += '<a class="btn btn-default btn-xs cmdAction expertModeVisible" data-action="configure"><i class="fa fa-cogs"></i></a> ';
		tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';
	}
	tr += '<td><i class="fa fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i></td>';
	tr += '</td>';
	tr += '</tr>';
	$('#table_cmd tbody').append(tr);
	$('#table_cmd tbody tr:last').setValues(_cmd, '.cmdAttr');
}

$('.eqLogicAttr[data-l1key=configuration][data-l2key=sendMode]').on('change', function () {
    $('.sendMode').hide();
    $('.sendMode.' + $(this).value()).show();
});

//$("#table_cmd").sortable({axis: "y", cursor: "move", items: ".cmd", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});model