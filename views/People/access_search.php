<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">
            <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
            <?php echo __('Поиск по категориям доступа'); ?>
        </h3>
    </div>
    
    <div class="panel-body">
        
        <!-- Форма поиска -->
        <div class="well well-sm">
            <form method="POST" action="<?php echo URL::site('people/access_search'); ?>" id="access-form">
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="access_filter">
                                <span class="glyphicon glyphicon-filter" aria-hidden="true"></span>
                                <?php echo __('Выберите категории доступа:'); ?>
                            </label>
                            
                            <!-- Поле для быстрого поиска по категориям -->
                            <div class="input-group" style="margin-bottom: 10px;">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                </span>
                                <input type="text" class="form-control" id="access-filter-input" 
                                       placeholder="<?php echo __('Фильтр категорий...'); ?>">
                                <span class="input-group-addon">
                                    <span class="badge" id="selected-count-badge">0</span>
                                </span>
                            </div>
                            
                            <!-- Список категорий с чекбоксами -->
                            <div class="access-list" style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; border-radius: 4px; padding: 10px; background: #f9f9f9;">
                                <div class="row">
                                    <?php if (!empty($access_names)): ?>
                                        <?php foreach ($access_names as $access): ?>
                                            <div class="col-sm-4 access-item" data-name="<?php echo strtolower($access['NAME']); ?>">
                                                <div class="checkbox" style="margin: 2px 0;">
                                                    <label>
                                                        <input type="checkbox" 
                                                               name="access_names[]" 
                                                               value="<?php echo $access['ID_ACCESSNAME']; ?>"
                                                               <?php echo in_array($access['ID_ACCESSNAME'], $selected_access) ? 'checked' : ''; ?>
                                                               class="access-checkbox">
                                                        <?php echo htmlspecialchars($access['NAME']); ?>
                                                        <?php 
                                                        $count = Model::factory('People')->getPeopleCountByAccess($access['ID_ACCESSNAME']);
                                                        if ($count > 0): 
                                                        ?>
                                                            <span class="badge"><?php echo $count; ?></span>
                                                        <?php endif; ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="col-sm-12">
                                            <p class="text-muted"><?php echo __('Категории доступа не найдены'); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Кнопки управления -->
                            <div style="margin-top: 10px;">
                                <button type="button" class="btn btn-default btn-sm" id="select-all">
                                    <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
                                    <?php echo __('Выбрать все'); ?>
                                </button>
                                <button type="button" class="btn btn-default btn-sm" id="deselect-all">
                                    <span class="glyphicon glyphicon-unchecked" aria-hidden="true"></span>
                                    <?php echo __('Снять все'); ?>
                                </button>
                                <button type="submit" class="btn btn-primary btn-sm pull-right">
                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                    <?php echo __('Найти'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
        
        <!-- Результаты поиска -->
        <?php if (!empty($people_list)): ?>
            <div class="panel panel-success" style="margin-top: 15px;">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                        <?php echo __('Результаты поиска'); ?>
                        <span class="badge pull-right"><?php echo count($people_list); ?></span>
                    </h4>
                </div>
                <div class="panel-body" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-condensed table-bordered" style="margin: 0;">
                            <thead>
                                <tr class="active">
                                    <th style="width: 50px;">
                                        <span class="glyphicon glyphicon-hash" aria-hidden="true"></span>
                                        ID
                                    </th>
                                    <th>
                                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                        <?php echo __('ФИО'); ?>
                                    </th>
                                    <th>
                                        <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                                        <?php echo __('Организация'); ?>
                                    </th>
                                    <th>
                                        <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                                        <?php echo __('Категории доступа'); ?>
                                    </th>
                                    <th class="text-center" style="width: 80px;">
                                        <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
                                        <?php echo __('Кол-во'); ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($people_list as $person): ?>
                                    <tr>
                                        <td class="text-center">
                                            <span class="label label-primary"><?php echo $person['ID_PEP']; ?></span>
                                        </td>
                                        <td>
                                            <?php echo HTML::anchor(
                                                'people/peopleInfo/' . $person['ID_PEP'],
                                                $person['SURNAME'] . ' ' . $person['NAME'] . ' ' . $person['PATRONYMIC'],
                                                array('title' => __('Перейти к карточке сотрудника'))
                                            ); ?>
                                            <?php if (!empty($person['NOTE'])): ?>
                                                <span class="text-muted small">(<?php echo htmlspecialchars($person['NOTE']); ?>)</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($person['ORG_NAME']); ?></td>
                                        <td>
                                            <?php 
                                            $access_names = explode(', ', $person['ACCESS_NAMES']);
                                            $display_names = array_slice($access_names, 0, 3);
                                            foreach ($display_names as $name):
                                            ?>
                                                <span class="label label-info" style="display: inline-block; margin: 1px 2px;">
                                                    <?php echo htmlspecialchars($name); ?>
                                                </span>
                                            <?php endforeach; ?>
                                            <?php if (count($access_names) > 3): ?>
                                                <span class="label label-default">+<?php echo count($access_names) - 3; ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge"><?php echo $person['ACCESS_COUNT']; ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php elseif (!empty($selected_access) && empty($people_list)): ?>
            <div class="alert alert-warning" style="margin-top: 15px;">
                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                <?php echo __('По выбранным категориям доступа сотрудники не найдены.'); ?>
            </div>
        <?php endif; ?>
        
    </div>
</div>

<!-- JavaScript -->
<script type="text/javascript">
$(document).ready(function() {
    
    // ===== Фильтр категорий =====
    $('#access-filter-input').on('keyup', function() {
        var filter = $(this).val().toLowerCase();
        $('.access-item').each(function() {
            var name = $(this).data('name');
            if (name.indexOf(filter) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    
    // ===== Выбрать все видимые =====
    $('#select-all').on('click', function() {
        $('.access-item:visible .access-checkbox').prop('checked', true);
        updateSelectedCount();
    });
    
    // ===== Снять все =====
    $('#deselect-all').on('click', function() {
        $('.access-checkbox').prop('checked', false);
        updateSelectedCount();
    });
    
    // ===== Обновление счетчика выбранных =====
    function updateSelectedCount() {
        var count = $('.access-checkbox:checked').length;
        $('#selected-count-badge').text(count);
    }
    
    // ===== Обновляем счетчик при изменении =====
    $('.access-checkbox').on('change', function() {
        updateSelectedCount();
    });
    
    // ===== Инициализация =====
    updateSelectedCount();
    
    // ===== Подсветка строк при наведении =====
    $('.table tbody tr').hover(
        function() {
            $(this).css('background-color', '#f0f8ff');
        },
        function() {
            $(this).css('background-color', '');
        }
    );
    
});
</script>

<style>
    /* Стили для списка категорий */
    .access-list {
        background: #f9f9f9;
    }
    
    .access-list .checkbox {
        margin: 3px 0;
        padding: 2px 5px;
        border-radius: 3px;
        transition: background 0.2s ease;
    }
    
    .access-list .checkbox:hover {
        background: #e8f0fe;
    }
    
    .access-list .checkbox label {
        width: 100%;
        cursor: pointer;
        font-weight: normal;
        font-size: 13px;
    }
    
    .access-list .checkbox input[type="checkbox"] {
        margin-right: 5px;
    }
    
    .access-list .badge {
        background-color: #337ab7;
        font-size: 10px;
        padding: 2px 6px;
        margin-left: 5px;
    }
    
    /* Стили для таблицы результатов */
    .table .label {
        font-size: 85%;
        padding: 2px 6px;
    }
    
    .table .label-info {
        background-color: #5bc0de;
    }
    
    .table .label-default {
        background-color: #777;
    }
    
    /* Анимация для кнопок */
    .btn {
        transition: all 0.2s ease;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    /* Адаптивность */
    @media (max-width: 768px) {
        .access-item {
            width: 100% !important;
        }
        
        .table-responsive {
            border: none;
        }
    }
</style>