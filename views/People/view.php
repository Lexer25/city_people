// people/views/People/view.php
// Заменяем блок с категориями доступа на сворачиваемый с динамической иконкой

<?php
//echo Debug::vars('2', $contact);
?>
<div class="panel panel-primary"> 

  <div class="panel-heading">
    <h3 class="panel-title"><?php echo __('people_panel_title')?></h3>
  </div>
  <div class="panel-body">
	
<?php // таблица общих данных о жильце?>
	<table class="table table-striped table-hover table-condensed table-bordered">
		<tr>
			<td>
			<?php if (Arr::get($contact, 'PHOTO') != null) { ?>
				<img src="data:image/jpeg;base64,<?php echo base64_encode($contact['PHOTO']); ?>" height="200" alt="photo" />
				 <?php } else { 
					echo HTML::image("images/nophoto.png", array('height' => 200, 'alt' => 'photo'));
			}
			
			?>
			</td>
			<td>
				<?php 
				echo Arr::get($contact,'SURNAME').' '.Arr::get($contact, 'NAME').' '.Arr::get($contact,'PATRONYMIC').'<br>';
				echo __('tabmum'). ' '.Arr::get($contact, 'TABNUM', __('No_card')).'<br>';
				echo __('id_pep'). ' '.Arr::get($contact, 'ID_PEP', __('No_card')).'<br>';
				echo __('card'). ' '.Arr::get($contact, 'ID_CARD', __('No_card'));
				if (Arr::get($contact, 'ID_CARDTYPE') == 1) echo  '('. Model::factory('Stat')->reviewKeyCode(Arr::get($contact, 'ID_CARD', __('No_card'))).')';
				
				
				//вывод активности идентификатора
				if(Arr::get($contact, 'CARD_IS_ACTIVE', 0) == 1)
				{

					echo ' <span class="label label-success">'.__('card_status_is_active').'</span><br>';
				} else {

					echo ' <span class="label label-danger">'.__('card_status_status_is_not_active').'</span><br>';
				}
				echo __('card_type'). ' '.Arr::get($contact, 'CARDTYPE', __('CARDTYPE')).'<br>';
				
				if(Arr::get($contact, 'TIMESTART') != NULL)
				{
					echo __('card_timestart'). ' '. date("d.m.Y H:i", strtotime(Arr::get($contact, 'TIMESTART', __('No_card'))));
				} else {
					echo __('card_timestart'). ' n/a';
				}
				
				echo '<br>';
						
				if(Arr::get($contact, 'TIMEEND') != NULL)
				{
					echo __('card_timeend'). ' '. date("d.m.Y H:i", strtotime(Arr::get($contact, 'TIMEEND', __('No_card'))));
				} else {
					echo __('card_timeend'). ' n/a';
				}
				echo '<br>';
				if(Arr::get($contact, 'tree') != null)
				{
					echo __('org_tree'). ' '. Arr::get($contact, 'tree');
				} else {
					echo __('no_org_tree');
				}
				?>
				
			</td>	
			<td>
				
				<?php // информация о типе авторизации
				
				echo __('about_pep_authmode'). '<br><br>';
				
				echo Model::factory('stat')->Authmode(Arr::get($contact, 'AUTHMODE', 0));
				
				echo Form::open('people/setAuthmetod');
				//echo Debug::vars('77', Model::Factory('stat')->authmodeList()); 
					echo Form::select('Authmode', Model::Factory('stat')->authmodeList(), Arr::get($contact, 'AUTHMODE', 0)).'<br>';
					echo Form::hidden('id_pep', Arr::get($contact, 'ID_PEP'));
					echo Form::hidden('id_card', Arr::get($contact, 'ID_CARD'));
					echo Form::submit(NULL, 'Authmode');
				echo Form::close();
				
				
				?>
				
			</td>	
			
		</tr>
	</table>

    <?php // НОВЫЙ БЛОК: Сворачиваемые категории доступа с динамической иконкой ?>
    <div class="panel panel-info" id="accessPanel">
        <div class="panel-heading" role="tab" id="accessHeading">
            <h3 class="panel-title">
                <a role="button" 
                   data-toggle="collapse" 
                   data-parent="#accordion" 
                   href="#accessCollapse" 
                   aria-expanded="true" 
                   aria-controls="accessCollapse"
                   id="accessToggle"
                   style="display: block; text-decoration: none; color: inherit;">
                    <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                    <?php echo __('Категории доступа'); ?>
                    <span class="badge pull-right">
                        <?php echo isset($access_categories) ? count($access_categories) : 0; ?>
                    </span>
                    <span class="pull-right toggle-icon" style="margin-right: 10px;">
                        <span class="glyphicon glyphicon-chevron-up" aria-hidden="true" id="iconCollapse"></span>
                        <span class="glyphicon glyphicon-chevron-down" aria-hidden="true" id="iconExpand" style="display: none;"></span>
                    </span>
                </a>
            </h3>
        </div>
        <div id="accessCollapse" 
             class="panel-collapse collapse in" 
             role="tabpanel" 
             aria-labelledby="accessHeading">
            <div class="panel-body">
                <?php if (isset($access_categories) && !empty($access_categories)): ?>
                    <div class="row">
                        <?php 
                        $total_categories = count($access_categories);
                        $columns = 3; // Количество колонок
                        $per_column = ceil($total_categories / $columns);
                        $current_index = 0;
                        ?>
                        
                        <?php for ($col = 0; $col < $columns; $col++): ?>
                            <div class="col-md-4 col-sm-6">
                                <?php for ($i = 0; $i < $per_column && $current_index < $total_categories; $i++, $current_index++): 
                                    $category = $access_categories[$current_index];
                                ?>
                                    <div style="margin-bottom: 5px;">
                                        <span class="label label-primary" style="display: inline-block; padding: 5px 10px; font-size: 12px; width: 100%;">
                                            <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
                                            <?php echo htmlspecialchars($category['NAME']); ?>
                                            <small class="text-muted" style="color: #d9edf7; float: right;">
                                                ID: <?php echo $category['ID_ACCESSNAME']; ?>
                                            </small>
                                        </span>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                    
                    <!-- Информация о количестве -->
                    <div style="margin-top: 15px; padding-top: 10px; border-top: 1px solid #eee;">
                        <small class="text-muted">
                            <span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
                            <?php echo __('Всего категорий') . ': ' . count($access_categories); ?>
                        </small>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info" style="margin: 0;">
                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                        <?php echo __('У сотрудника нет категорий доступа'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
	
<!--// people/views/People/view.php
// Обновляем блок "Точки прохода" с добавлением родительского контроллера-->

    <?php // НОВЫЙ БЛОК: Точки прохода с группировкой категорий ?>
    <div class="panel panel-success" id="devicesPanel">
        <div class="panel-heading" role="tab" id="devicesHeading">
            <h3 class="panel-title">
                <a role="button" 
                   data-toggle="collapse" 
                   data-parent="#accordion" 
                   href="#devicesCollapse" 
                   aria-expanded="true" 
                   aria-controls="devicesCollapse"
                   id="devicesToggle"
                   style="display: block; text-decoration: none; color: inherit;">
                    <span class="glyphicon glyphicon-screenshot" aria-hidden="true"></span>
                    <?php echo __('Точки прохода'); ?>
                    <span class="badge pull-right">
                        <?php echo isset($access_devices) ? count($access_devices) : 0; ?>
                    </span>
                    <span class="pull-right toggle-icon" style="margin-right: 10px;">
                        <span class="glyphicon glyphicon-chevron-up" aria-hidden="true" id="devicesIconCollapse"></span>
                        <span class="glyphicon glyphicon-chevron-down" aria-hidden="true" id="devicesIconExpand" style="display: none;"></span>
                    </span>
                </a>
            </h3>
        </div>
        <div id="devicesCollapse" 
             class="panel-collapse collapse in" 
             role="tabpanel" 
             aria-labelledby="devicesHeading">
            <div class="panel-body">
                <?php if (isset($access_devices) && !empty($access_devices)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-condensed table-bordered">
                            <thead>
                                <tr class="active">
                                    <th style="width: 40px;">#</th>
                                    <th><?php echo __('Точка прохода'); ?></th>
                                    <th><?php echo __('Категории доступа'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $row_num = 1;
                                foreach ($access_devices as $device): 
                                    $status_color = ($device['DEVICE_ACTIVE'] == 1) ? 'success' : 'danger';
                                    $status_text = ($device['DEVICE_ACTIVE'] == 1) ? __('Активно') : __('Неактивно');
                                    
                                    // Статус контроллера
                                    $controller_status_color = 'default';
                                    $controller_status_text = '—';
                                    if (isset($device['CONTROLLER_ACTIVE'])) {
                                        $controller_status_color = ($device['CONTROLLER_ACTIVE'] == 1) ? 'success' : 'danger';
                                        $controller_status_text = ($device['CONTROLLER_ACTIVE'] == 1) ? __('Активно') : __('Неактивно');
                                    }
                                ?>
                                    <tr>
                                        <td class="text-center"><?php echo $row_num++; ?></td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                                <span class="label label-<?php echo $status_color; ?>" style="font-size: 10px; min-width: 60px;">
                                                    <?php echo $status_text; ?>
                                                </span>
                                                <strong><?php echo htmlspecialchars($device['DEVICE_NAME']); ?></strong>
                                                <small class="text-muted">(ID: <?php echo $device['ID_DEV']; ?>)</small>
                                            </div>
                                            
                                            <!-- Информация об устройстве -->
                                            <div style="margin-top: 4px; font-size: 11px; color: #666;">
                                                <?php if ($device['DEVTYPE_NAME'] != '—'): ?>
                                                    <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
                                                    <?php echo htmlspecialchars($device['DEVTYPE_NAME']); ?>
                                                <?php endif; ?>
                                                
                                                <?php if ($device['ID_READER']): ?>
                                                    <span class="glyphicon glyphicon-qrcode" aria-hidden="true" style="margin-left: 10px;"></span>
                                                    Reader: <?php echo $device['ID_READER']; ?>
                                                <?php endif; ?>
                                                
                                                <?php if ($device['NETADDR']): ?>
                                                    <span class="glyphicon glyphicon-globe" aria-hidden="true" style="margin-left: 10px;"></span>
                                                    <code><?php echo htmlspecialchars($device['NETADDR']); ?></code>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <!-- Информация о родительском контроллере -->
                                            <?php if (isset($device['CONTROLLER_NAME']) && $device['CONTROLLER_NAME'] != '—'): ?>
                                                <div style="margin-top: 4px; padding: 3px 8px; background-color: #f8f8f8; border-radius: 3px; font-size: 11px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                                    <span class="glyphicon glyphicon-th-large" aria-hidden="true" style="color: #337ab7;"></span>
                                                    <span style="color: #555;"><?php echo __('Родительский контроллер') . ':'; ?></span>
                                                    <span class="label label-<?php echo $controller_status_color; ?>" style="font-size: 9px; padding: 1px 6px;">
                                                        <?php echo $controller_status_text; ?>
                                                    </span>
                                                    <strong style="color: #337ab7;"><?php echo htmlspecialchars($device['CONTROLLER_NAME']); ?></strong>
                                                    <small class="text-muted">(ID: <?php echo $device['CONTROLLER_ID']; ?>)</small>
                                                    
                                                    <?php if ($device['CONTROLLER_IP']): ?>
                                                        <span class="glyphicon glyphicon-globe" aria-hidden="true" style="color: #999; margin-left: 5px;"></span>
                                                        <code style="font-size: 10px;"><?php echo htmlspecialchars($device['CONTROLLER_IP']); ?></code>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (isset($device['SERVER_NAME']) && $device['SERVER_NAME'] != '—'): ?>
                                                        <span class="glyphicon glyphicon-hdd" aria-hidden="true" style="color: #999; margin-left: 5px;"></span>
                                                        <span style="color: #999;"><?php echo htmlspecialchars($device['SERVER_NAME']); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php else: ?>
                                                <div style="margin-top: 4px; padding: 3px 8px; background-color: #f8f8f8; border-radius: 3px; font-size: 11px; color: #999;">
                                                    <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
                                                    <?php echo __('Родительский контроллер не найден'); ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                                                <?php 
                                                $access_names = $device['ACCESS_NAMES'];
                                                $total_access = count($access_names);
                                                $display_count = 5; // Показываем первые 5 категорий
                                                
                                                foreach (array_slice($access_names, 0, $display_count) as $access_name): 
                                                ?>
                                                    <span class="label label-info" style="font-size: 11px; padding: 3px 8px;">
                                                        <span class="glyphicon glyphicon-tag" aria-hidden="true" style="font-size: 9px;"></span>
                                                        <?php echo htmlspecialchars($access_name); ?>
                                                    </span>
                                                <?php endforeach; ?>
                                                
                                                <?php if ($total_access > $display_count): ?>
                                                    <span class="label label-default" style="font-size: 11px; padding: 3px 8px; background-color: #777;">
                                                        +<?php echo ($total_access - $display_count); ?> 
                                                        <?php echo __('еще'); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div style="margin-top: 4px; font-size: 10px; color: #999;">
                                                <span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
                                                <?php echo __('Всего категорий') . ': ' . $total_access; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="info">
                                    <td colspan="3">
                                        <small class="text-muted">
                                            <span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
                                            <?php echo __('Всего точек прохода') . ': ' . count($access_devices); ?>
                                        </small>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info" style="margin: 0;">
                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                        <?php echo __('У сотрудника нет точек прохода'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

	

<?php // таблица последний событий жильца?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo __('people_event_title', array(':dateFrom'=>Arr::get($_SESSION, 'peopleEventsTimeFrom', date("d.m.Y H:i:s",strtotime("-1 days"))), ':dateTo'=>Arr::get($_SESSION, 'peopleEventsTimeTo', date("d.m.Y H:i:s"))))?></h3>
		</div>	
	<?php //echo Debug::vars('88', $events);?>
	<table class="table table-striped table-hover table-condensed table-bordered">
					<tr>
						<th><?php echo __('timestamp');?></th>
						<th><?php echo __('door');?></th>
						<th><?php echo __('card');?></th>
						<th><?php echo __('note');?></th>
						<th><?php echo __('event_name');?></th>
						<th><?php echo __('event_analit');?></th>
					</tr>
						
				<?php foreach ($events as $key=>$value)
				{
					$tr_color='warning';
					if(Arr::get($value, 'EVENT_ANALIT') == 0) $tr_color='success';
					echo '<tr class="'.$tr_color.'">';;
						echo '<td>'.date("d.m.Y H:i:s", strtotime(Arr::get($value, 'DATETIME'))).'</td>';
						echo '<td>'.Arr::get($value, 'DOOR_NAME').'(ID_DEV='.Arr::get($value, 'ID_DEV').')</td>';
						echo '<td>'.Arr::get($value, 'ID_CARD').'</td>';
						echo '<td>'.Arr::get($value, 'NOTE').'</td>';
						echo '<td>'.Arr::get($value, 'EVENT_NAME').'</td>';
						echo '<td>';
							echo(Arr::get($value, 'EVENT_ANALIT') == 1)? 'Да':'Нет';
							echo ' ('.Arr::get($value, 'ANALIT_CODE').' ';
							echo __(Arr::get($value, 'ANALIT_CODE').'a').')<br>';
							if(Arr::get($value, 'ANALIT_CODE') == 657) {
								$resultLoad=Arr::get($doors, Arr::get($value, 'ID_DEV'));
								echo '<small>';
								//echo Debug::vars('116', $resultLoad);
								echo __('load_result').': ';
								if(is_null(Arr::get($resultLoad, 'LOAD_TIME'))) {
									echo __('no_result_load_card_in_device', 
										array('LOAD_RESULT'=>Arr::get($resultLoad, 'LOAD_RESULT'), 
											'CONTROLLER_NAME'=> Arr::get($resultLoad, 'CONTROLLER_NAME'), 
											'DEVIDX'=> Arr::get($resultLoad, 'DEVIDX'),
											'ID_READER'=> Arr::get($resultLoad, 'ID_READER'), 
											'SERVER_NAME'=> Arr::get($resultLoad, 'SERVER_NAME'),
											'ID_DEV'=> Arr::get($resultLoad, 'ID_DEV')));
										echo __('no_date_for_load_card_in_device');
								} else { 
									echo __('result_load_card_in_device', 
										array('LOAD_RESULT'=>Arr::get($resultLoad, 'LOAD_RESULT'), 
										'CONTROLLER_NAME'=> Arr::get($resultLoad, 'CONTROLLER_NAME'), 
										'DEVIDX'=> Arr::get($resultLoad, 'DEVIDX'),
										'ID_READER'=> Arr::get($resultLoad, 'ID_READER'), 
										'SERVER_NAME'=> Arr::get($resultLoad, 'SERVER_NAME'),
										'ID_DEV'=> Arr::get($resultLoad, 'ID_DEV')));
									echo date("d.m.Y H:i:s", strtotime(Arr::get($resultLoad, 'LOAD_TIME')));
								}
									echo '</small>';
							}		//echo Debug::vars('114', $resultLoad);
																		
							echo '</td>';
					echo '</tr>';
					
				}
							
				?>
	</table>
	</div>
	
	<?php // таблица загрузки карты жильца в контроллеры?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo __('people_load_card')?></h3>
		</div>	
				<table class="table table-striped table-hover table-condensed table-bordered">
					<tr>
						<th><?php echo __('SER_NUM');?></th>
						<th><?php echo __('door');?></th>
						<th><?php echo __('load_result');?></th>
						<th><?php echo __('load_time');?></th>
						<th><?php echo __('load_del');?></th>
						<th><?php echo __('load_insert');?></th>
				<?php
				$row_count=1;
			//	echo Debug::vars('139', $doors);exit;
				foreach ($doors as $key=>$value)
				{
					echo '<tr>';
						echo '<td>'.$row_count++.'</td>';
						echo '<td>'.Arr::get($value, 'NAME').'('.Arr::get($value, 'ID_DEV').')'.' '.Arr::get($value, 'STANDALONE').'  </td>';
						
						if(Arr::get($value, 'STANDALONE') == 0){
							echo '<td>'.__('standalone').'</td>';
							echo '<td>--</td>';
						} else {
							if(is_null(Arr::get($value, 'LOAD_TIME'))) {
								echo '<td>'.__('no_result_load_card_in_device', array('LOAD_RESULT'=>Arr::get($value, 'LOAD_RESULT'), 'CONTROLLER_NAME'=> Arr::get($value, 'CONTROLLER_NAME'), 'DEVIDX'=> Arr::get($value, 'DEVIDX'),'ID_READER'=> Arr::get($value, 'ID_READER'), 'SERVER_NAME'=> Arr::get($value, 'SERVER_NAME'))).'</td>';
								echo '<td>'.__('no_date_for_load_card_in_device').'</td>';
							} else { 
								echo '<td>'.__('result_load_card_in_device', array('LOAD_RESULT'=>Arr::get($value, 'LOAD_RESULT'), 'CONTROLLER_NAME'=> Arr::get($value, 'CONTROLLER_NAME'), 'DEVIDX'=> Arr::get($value, 'DEVIDX'),'ID_READER'=> Arr::get($value, 'ID_READER'), 'SERVER_NAME'=> Arr::get($value, 'SERVER_NAME'))).'</td>';
								echo '<td>'.date("d.m.Y H:i:s", strtotime(Arr::get($value, 'LOAD_TIME'))).'</td>';
							}
						}	
						
						echo '<td>';
							if(isset($value['LOAD_DEL'])) echo date("d.m.Y H:i:s", strtotime(Arr::get($value, 'LOAD_DEL')));
						echo '</td>';
						echo '<td>';
							if(Arr::get($value, 'LOAD_INSERT')==1) {
							echo HTML::image('static\images\green-check.png', array('alt' => 'Карта стоит в очереди на загрузку', 'title'=>Arr::get($value, 'TIME_INSERT')));
							} else {
								echo __('no');
							}
							
						echo '</td>';
						
					echo '</tr>';
					
				}
							
				?>
				</table>
	</div>

</div>	
</div>
// people/views/People/view.php
// Добавить в конце перед закрывающим тегом </div>

<script type="text/javascript">
$(document).ready(function() {
    // Управление иконкой сворачивания/разворачивания
    $('#accessCollapse').on('shown.bs.collapse', function() {
        // Блок развернут - показываем иконку "свернуть" (вверх)
        $('#iconCollapse').show();
        $('#iconExpand').hide();
        // Обновляем aria-expanded
        $('#accessToggle').attr('aria-expanded', 'true');
    });
    
    $('#accessCollapse').on('hidden.bs.collapse', function() {
        // Блок свернут - показываем иконку "развернуть" (вниз)
        $('#iconCollapse').hide();
        $('#iconExpand').show();
        // Обновляем aria-expanded
        $('#accessToggle').attr('aria-expanded', 'false');
    });
    
    // Инициализация: если блок по умолчанию развернут (class="in")
    if ($('#accessCollapse').hasClass('in')) {
        $('#iconCollapse').show();
        $('#iconExpand').hide();
        $('#accessToggle').attr('aria-expanded', 'true');
    } else {
        $('#iconCollapse').hide();
        $('#iconExpand').show();
        $('#accessToggle').attr('aria-expanded', 'false');
    }
});
</script>

// people/views/People/view.php
// Добавляем в существующий скрипт

<script type="text/javascript">
$(document).ready(function() {
    // ===== Управление иконкой для категорий доступа =====
    $('#accessCollapse').on('shown.bs.collapse', function() {
        $('#iconCollapse').show();
        $('#iconExpand').hide();
        $('#accessToggle').attr('aria-expanded', 'true');
    });
    
    $('#accessCollapse').on('hidden.bs.collapse', function() {
        $('#iconCollapse').hide();
        $('#iconExpand').show();
        $('#accessToggle').attr('aria-expanded', 'false');
    });
    
    // Инициализация для категорий доступа
    if ($('#accessCollapse').hasClass('in')) {
        $('#iconCollapse').show();
        $('#iconExpand').hide();
        $('#accessToggle').attr('aria-expanded', 'true');
    } else {
        $('#iconCollapse').hide();
        $('#iconExpand').show();
        $('#accessToggle').attr('aria-expanded', 'false');
    }
    
    // ===== Управление иконкой для точек прохода =====
    $('#devicesCollapse').on('shown.bs.collapse', function() {
        $('#devicesIconCollapse').show();
        $('#devicesIconExpand').hide();
        $('#devicesToggle').attr('aria-expanded', 'true');
    });
    
    $('#devicesCollapse').on('hidden.bs.collapse', function() {
        $('#devicesIconCollapse').hide();
        $('#devicesIconExpand').show();
        $('#devicesToggle').attr('aria-expanded', 'false');
    });
    
    // Инициализация для точек прохода
    if ($('#devicesCollapse').hasClass('in')) {
        $('#devicesIconCollapse').show();
        $('#devicesIconExpand').hide();
        $('#devicesToggle').attr('aria-expanded', 'true');
    } else {
        $('#devicesIconCollapse').hide();
        $('#devicesIconExpand').show();
        $('#devicesToggle').attr('aria-expanded', 'false');
    }
    
    // ===== Подсветка строк таблицы при наведении =====
    $('#devicesCollapse .table tbody tr').hover(
        function() {
            $(this).css('background-color', '#f0f8ff');
        },
        function() {
            $(this).css('background-color', '');
        }
    );
});
</script>