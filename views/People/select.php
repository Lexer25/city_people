<?php 
// echo Debug::vars('11', $list);
?>

<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo __('people_panel_title'); ?></h3>
  </div>
  <div class="panel-body">
    
    <?php if (empty($list)): ?>
      <div class="alert alert-info">
        <?php echo __('no_records_found'); ?>
      </div>
    <?php else: ?>
      
      <div class="table-responsive">
        <table class="table table-striped table-hover table-condensed table-bordered">
          <thead>
            <tr class="active">
              <th><?php echo __('pep_id'); ?></th>
              <th><?php echo __('name'); ?></th>
              <th><?php echo __('org_name'); ?></th>
              <th><?php echo __('card'); ?></th>
              <th><?php echo __('card_type'); ?></th>
              <th><?php echo __('card_status'); ?></th>
              <th><?php echo __('card_date_end'); ?></th>
              <th><?php echo __('about_pep_authmode'); ?></th>
              <th><?php echo __('last_event'); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($list as $key => $contact): ?>
              <?php 
                // Получаем статус карты
                $status_color = Arr::get($contact, 'CARD_STATUS_COLOR', 'default');
                $status_text = Arr::get($contact, 'CARD_STATUS_TEXT', __('Неизвестно'));
              ?>
              <tr>
                <td><?php echo Arr::get($contact, 'ID_PEP'); ?></td>
                
                <td>
                  <?php echo HTML::anchor(
                    'people/peopleInfo/' . Arr::get($contact, 'ID_PEP') . '/' . Arr::get($contact, 'ID_CARD', __('No_card')),
                    Arr::get($contact, 'SURNAME') . ' ' . Arr::get($contact, 'NAME') . ' ' . Arr::get($contact, 'PATRONYMIC')
                  ); ?>
                </td>
                
                <td><?php echo Arr::get($contact, 'ORG_NAME', __('No_organization')); ?></td>
                
                <td>
                  <code><?php echo Arr::get($contact, 'ID_CARD', __('No_card')); ?></code>
                </td>
                
                <td><?php echo Arr::get($contact, 'CARDTYPENAME', __('No_cardtype')); ?></td>
                
                <td>
                  <span class="label label-<?php echo $status_color; ?>">
                    <?php 
                      // Иконка в зависимости от статуса
                      if ($status_color == 'success') {
                        echo '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ';
                      } elseif ($status_color == 'warning') {
                        echo '<span class="glyphicon glyphicon-time" aria-hidden="true"></span> ';
                      } elseif ($status_color == 'danger') {
                        echo '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> ';
                      }
                      echo $status_text; 
                    ?>
                  </span>
                  
                  <?php if ($status_color == 'warning'): ?>
                    <small class="text-muted" style="display: block; font-size: 9px;">
                      <?php echo __('Истекает') . ': ' . date("d.m.Y", strtotime(Arr::get($contact, 'CARD_TIMEEND'))); ?>
                    </small>
                  <?php endif; ?>
                </td>
                
                <td>
                  <?php 
                    $timeend = Arr::get($contact, 'CARD_TIMEEND');
                    if (!empty($timeend) && $timeend != __('No_card')) {
                      echo date("d.m.Y", strtotime($timeend));
                    } else {
                      echo '—';
                    }
                  ?>
                </td>
                
                <td><?php echo Model::factory('stat')->Authmode(Arr::get($contact, 'AUTHMODE', 0)); ?></td>
                
                <td>
                  <?php 
                    $last_event = Arr::get($contact, 'MAX');
                    if (!empty($last_event)) {
                      echo date("d.m.Y H:i", strtotime($last_event));
                    } else {
                      echo '<span class="text-muted">' . __('Нет событий') . '</span>';
                    }
                  ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr class="info">
              <td colspan="9">
                <small class="text-muted">
                  <span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
                  <?php echo __('Всего найдено') . ': ' . count($list); ?>
                </small>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
      
    <?php endif; ?>
    
  </div>  
</div>