<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            <?php echo __('people_panel_title'); ?>
        </h3>
    </div>
    
    <div class="panel-body">
        
        <!-- Все формы в одной строке -->
        <div class="row">
            
            <!-- Поиск по ФИО -->
            <div class="col-sm-5">
                <div class="panel panel-default" style="border-color: #e7e7e7; margin-bottom: 0;">
                    <div class="panel-heading" style="background-color: #f9f9f9; padding: 8px 12px;">
                        <h4 class="panel-title" style="font-size: 13px;">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            <?php echo __('По ФИО'); ?>
                        </h4>
                    </div>
                    <div class="panel-body" style="padding: 10px 12px;">
                        <form role="search" action="find" method="GET">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-font" aria-hidden="true"></span>
                                </span>
                                <input type="text" class="form-control" 
                                       placeholder="ФИО (мин. 3 буквы)" 
                                       name="peopleInfo" 
                                       autofocus>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                    </button>
                                </span>
                            </div>
                            
                            <!-- Период в одной строке -->
                            <div class="row" style="margin-top: 8px;">
                                <div class="col-xs-5" style="padding-right: 2px;">
                                    <div class="input-group date input-group-sm" id="datetimepicker1">
                                        <input type="text" class="form-control" name="timeFrom" 
                                               placeholder="с" style="font-size: 11px;">
                                        <span class="input-group-addon" style="padding: 0 5px;">
                                            <span class="glyphicon glyphicon-calendar" style="font-size: 11px;"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-2 text-center" style="padding: 0 2px;">
                                    <span class="text-muted" style="font-size: 11px;">по</span>
                                </div>
                                <div class="col-xs-5" style="padding-left: 2px;">
                                    <div class="input-group date input-group-sm" id="datetimepicker2">
                                        <input type="text" class="form-control" name="timeTo" 
                                               placeholder="по" style="font-size: 11px;">
                                        <span class="input-group-addon" style="padding: 0 5px;">
                                            <span class="glyphicon glyphicon-calendar" style="font-size: 11px;"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Поиск по карте -->
            <div class="col-sm-4">
                <div class="panel panel-default" style="border-color: #e7e7e7; margin-bottom: 0;">
                    <div class="panel-heading" style="background-color: #f9f9f9; padding: 8px 12px;">
                        <h4 class="panel-title" style="font-size: 13px;">
                            <span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
                            <?php echo __('По карте'); ?>
                        </h4>
                    </div>
                    <div class="panel-body" style="padding: 10px 12px;">
                        <form role="search" action="findAnyCard" method="POST">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span>
                                </span>
                                <input type="text" class="form-control" 
                                       placeholder="Номер карты" 
                                       name="getCardInfo">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                    </button>
                                </span>
                            </div>
                            
                            <!-- Радио-кнопки в одну строку -->
                            <div class="row" style="margin-top: 8px;">
								<div class="col-xs-4" style="padding-left: 2px;">
                                    <label style="font-weight: normal; font-size: 11px; margin: 0;">
                                        <input type="radio" name="keyFormat" value="none" checked> 
                                        <span class="label label-warning" style="font-size: 10px;">Нет</span>
                                    </label>
                                </div>
                                <div class="col-xs-4" style="padding-right: 2px;">
                                    <label style="font-weight: normal; font-size: 11px; margin: 0;">
                                        <input type="radio" name="keyFormat" value="hex"> 
                                        <span class="label label-info" style="font-size: 10px;">HEX</span>
                                    </label>
                                </div>
                                <div class="col-xs-4" style="padding: 0 2px;">
                                    <label style="font-weight: normal; font-size: 11px; margin: 0;">
                                        <input type="radio" name="keyFormat" value="dec"> 
                                        <span class="label label-success" style="font-size: 10px;">DEC</span>
                                    </label>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Поиск по ID -->
            <div class="col-sm-3">
                <div class="panel panel-default" style="border-color: #e7e7e7; margin-bottom: 0;">
                    <div class="panel-heading" style="background-color: #f9f9f9; padding: 8px 12px;">
                        <h4 class="panel-title" style="font-size: 13px;">
                            <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span>
                            <?php echo __('По ID'); ?>
                        </h4>
                    </div>
                    <div class="panel-body" style="padding: 10px 12px;">
                        <form role="search" action="findID" method="POST">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
                                </span>
                                <input type="number" class="form-control" 
                                       placeholder="ID" 
                                       name="idPepInfo" 
                                       min="1">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                    </button>
                                </span>
                            </div>
                            <div style="margin-top: 8px; font-size: 10px; color: #999;">
                                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                Числовой ID
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Быстрые ссылки - в одну строку -->
        <div class="row" style="margin-top: 15px; border-top: 1px solid #eee; padding-top: 12px;">
            <div class="col-sm-12">
                <div class="btn-group btn-group-sm" role="group" style="display: flex;">
                    <a href="<?php echo URL::site('people/find_card_late'); ?>" 
                       class="btn btn-warning" style="flex: 1; font-size: 12px; padding: 5px 3px;">
                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        <?php echo __('Просроченные'); ?>
                    </a>
                    <a href="<?php echo URL::site('people/find_card_late_next_week'); ?>" 
                       class="btn btn-info" style="flex: 1; font-size: 12px; padding: 5px 3px;">
                        <span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span>
                        <?php echo __('Истекают'); ?>
                    </a>
                    <a href="<?php echo URL::site('people/people_without_card'); ?>" 
                       class="btn btn-danger" style="flex: 1; font-size: 12px; padding: 5px 3px;">
                        <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
                        <?php echo __('Без карты'); ?>
                    </a>
                    <a href="<?php echo URL::site('people/people_without_events'); ?>" 
                       class="btn btn-default" style="flex: 1; font-size: 12px; padding: 5px 3px;">
                        <span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
                        <?php echo __('Без событий'); ?>
                    </a>
                    <a href="<?php echo URL::site('people/find_unActiveCard'); ?>" 
                       class="btn btn-default" style="flex: 1; font-size: 12px; padding: 5px 3px;">
                        <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        <?php echo __('Неактивные'); ?>
                    </a>
                </div>
            </div>
        </div>
        
    </div>
</div>

<!-- Подключение скриптов -->
<script type="text/javascript">
    $(function () {
        // Установка начальных значений даты
        var dateEnd = new Date();
        dateEnd.setHours(23, 59, 59, 0);
        
        var dateBegin = new Date();
        dateBegin.setDate(dateBegin.getDate() - 1);
        dateBegin.setHours(0, 0, 0, 0);
        
        // Инициализация datetimepicker1 и datetimepicker2
        $("#datetimepicker1").datetimepicker({
            language: 'ru',
            showToday: true,
            sideBySide: true,
            defaultDate: dateBegin,
            useCurrent: false
        });
        
        $("#datetimepicker2").datetimepicker({
            language: 'ru',
            showToday: true,
            sideBySide: true,
            defaultDate: dateEnd,
            useCurrent: false
        });
        
        // При изменении даты в 1 datetimepicker, она устанавливается как минимальная для 2 datetimepicker
        $("#datetimepicker1").on("dp.change", function (e) {
            $("#datetimepicker2").data("DateTimePicker").setMinDate(e.date);
        });
        
        // При изменении даты в 2 datetimepicker, она устанавливается как максимальная для 1 datetimepicker
        $("#datetimepicker2").on("dp.change", function (e) {
            $("#datetimepicker1").data("DateTimePicker").setMaxDate(e.date);
        });
        
        // Автофокус на первом поле
        $('input[name="peopleInfo"]').focus();
        
        // Обработка Enter для всех форм
        $('form').on('keypress', function(e) {
            if (e.which === 13) {
                $(this).submit();
                return false;
            }
        });
        
        // Валидация ID (только цифры)
        $('input[name="idPepInfo"]').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>

<!-- Дополнительные стили -->
<style>
    /* Уменьшаем отступы для компактности */
    .panel-body {
        padding: 12px 15px;
    }
    
    .panel-heading {
        padding: 8px 12px;
    }
    
    .panel-heading .panel-title {
        font-size: 13px;
    }
    
    /* Уменьшаем размер шрифта для компактности */
    .input-group-sm .form-control {
        font-size: 12px;
        height: 28px;
        padding: 4px 8px;
    }
    
    .input-group-sm .input-group-addon {
        font-size: 12px;
        padding: 4px 8px;
        height: 28px;
    }
    
    .input-group-sm .btn {
        font-size: 12px;
        padding: 4px 8px;
        height: 28px;
    }
    
    /* Улучшение внешнего вида */
    .panel-default {
        transition: box-shadow 0.3s ease;
        height: 100%;
    }
    
    .panel-default:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    /* Стили для радио-кнопок в компактном виде */
    .radio-inline {
        font-size: 11px;
        margin: 0;
        padding: 2px 8px;
    }
    
    .radio-inline input[type="radio"] {
        margin-right: 2px;
        margin-top: 1px;
    }
    
    .radio-inline .label {
        font-size: 10px;
        padding: 1px 5px;
    }
    
    /* Компактные кнопки быстрых ссылок */
    .btn-group-sm .btn {
        padding: 4px 3px;
        font-size: 11px;
        white-space: nowrap;
    }
    
    .btn-group-sm .btn .glyphicon {
        font-size: 11px;
        margin-right: 2px;
    }
    
    /* Адаптивность */
    @media (max-width: 992px) {
        .col-sm-5, .col-sm-4, .col-sm-3 {
            width: 100% !important;
            margin-bottom: 10px;
        }
        
        .panel-default {
            height: auto;
        }
        
        .btn-group-sm .btn {
            white-space: normal;
            font-size: 10px;
        }
    }
    
    @media (max-width: 768px) {
        .row > div {
            margin-bottom: 10px;
        }
        
        .btn-group-sm {
            flex-wrap: wrap;
        }
        
        .btn-group-sm .btn {
            flex: 1 1 33%;
            margin-bottom: 3px;
            font-size: 10px;
            padding: 4px 2px;
        }
    }
</style>