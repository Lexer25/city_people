<?php defined('SYSPATH') or die('No direct script access.');
class Controller_People extends Controller_Template { 

	public function before()
	{
			
			parent::before();
			$session = Session::instance();
			//echo Debug::vars('9');//exit;
			
	}
	
	
	
	public function action_index()
	{
		$_SESSION['menu_active']='people';
		
		$content = View::factory('people/search');
        $this->template->content = $content;
	}
	 
	public function action_setAuthmetod()//Установка метода авториза
	{
		//echo Debug::vars('24', $this->request->post());exit;
		$post=Validation::factory($this->request->post());
		$post->rule('Authmode', 'not_empty')
						->rule('Authmode', 'digit')
						->rule('id_pep', 'not_empty')
						->rule('id_pep', 'digit')
						->rule('id_card', 'not_empty')
						;
		if($post->check())
				{
					Model::Factory('People')->setAuthMetod(Arr::get($post, 'id_pep'), Arr::get($post, 'Authmode'));
					$this->redirect('people/peopleInfo/'.Arr::get($post, 'id_pep').'/'.Arr::get($post, 'id_card'));
				}
				else {
					echo Debug::vars('37'); exit;
				}
		
	}
	 
	 
	 
	 public function action_people_delete()
	 {
	 	//echo Debug::vars('23', $_POST); exit;
	 	if (Arr::get($_POST, 'people_delete')) Model::Factory('People')->People_delete(Arr::get($_POST, 'id_pep'));
	 	if (Arr::get($_POST, 'people_long')) Model::Factory('People')->card_People_long(Arr::get($_POST, 'id_pep'), Arr::get($_POST, 'timeTo'));
	 	if (Arr::get($_POST, 'card_late_save_to_file')) $this->action_card_late_save_to_file();
	 	if (Arr::get($_POST, 'people_unactive')) Model::Factory('People')->card_people_unactive(Arr::get($_POST, 'id_pep'));// обновлено 13.01.2025
	 	if (Arr::get($_POST, 'card_delete')) Model::Factory('People')->card_card_delete(Arr::get($_POST, 'id_pep'));// обновлено 13.01.2025
	 	
	 	$this->redirect('people/find_card_late');
	 	
	 }
	
	 
	 public function action_find()
	 {
	 	//echo Debug::vars('61', $_GET); exit;
		$search=Arr::get($_GET, 'peopleInfo');
	 	$_SESSION['peopleEventsTimeFrom']=Arr::get($_GET, 'timeFrom', Date::formatted_time('-2 days', "d.m.Y H:i:s"));
	 	$_SESSION['peopleEventsTimeTo']=Arr::get($_GET, 'timeTo',Date::formatted_time('now', "d.m.Y H:i:s"));
		$result=Model::Factory('People')->findIdPep($search);// поиск жильцов, совпадающих с введенным именем
		if(count($result)>0)
		 {
			$content=View::Factory('people/select', array(
			'list' => $result,
			));
		 $this->template->content = $content;
		 
		 } else {
		 $content=View::Factory('people/search');
		 $this->template->content = $content;
		 }
	 }
	 
	 
	 public function action_findID()//13.02.2022 поиск пользователя по ID_PEP
	 {
	 	
		$post=Validation::factory($this->request->post());
				//echo Debug::vars('82', $_POST, $post); exit;
		$post->rule('idPepInfo', 'not_empty')
						->rule('idPepInfo', 'digit')
						;
		if($post->check())
		{
			//echo Debug::vars('95');exit;
			$id_pep=Arr::get($post, 'idPepInfo');
			$_SESSION['peopleEventsTimeFrom']=Arr::get($_GET, 'timeFrom', Date::formatted_time('-2 days', "d.m.Y H:i:s"));
			$_SESSION['peopleEventsTimeTo']=Arr::get($_GET, 'timeTo',Date::formatted_time('now', "d.m.Y H:i:s"));
			$result=Model::Factory('People')->findIdPepInfo(array($id_pep));// поиск ID жильцов по указанном ID_PEP
		
			if(count($result)>0)
			 {
				$content=View::Factory('people/select', array(
				'list' => $result,
				));
			 $this->template->content = $content;
			 
			 } else {
			 $content=View::Factory('people/search');
			 $this->template->content = $content;
			 }
		 } else {
			 //echo Debug::vars('108', $param->errors());exit;
		 }
	 }
	 
	 
	public function action_findAnyCard()//13.02.2022 поиск пользователя по номеру карты
	 {
	 	//echo Debug::vars('115', $this->request->post()); //exit;
		//echo Debug::vars('116',$_POST);exit;
		//echo Debug::vars('139 baseFormatRfid ', Kohana::$config->load('artonitcity_config')->baseFormatRfid);//exit;
		
		$key='';
		$post=Validation::factory($this->request->post());
		//echo Debug::vars('121',$post,Arr::get($post, 'keyFormat'),Arr::get($post, 'getCardInfo'));exit;
		
		switch(Arr::get($post, 'keyFormat')){
			case 'dec': // номер для поиска - десятичное число. Валидирую и преобразую к формату хранения в бд.
				$post->rule('getCardInfo', 'not_empty')
								->rule('getCardInfo', 'digit')
								;
				if($post->check()){// номер передан в формате целого десятичного числа
				
					//echo Debug::vars('126 число десятичное!');
					//преобразую целое длинное число к формат 001А
					switch(Kohana::$config->load('artonitcity_config')->baseFormatRfid){
						case 0: //baseFormatRfid hex8
						//преобразование длинного десятичного числа к HEX
							//$key=Model::Factory('Stat')->decDigitTo001A(Arr::get($post, 'getCardInfo'));
							$key= STR_PAD(strtoupper(dechex(Arr::get($post, 'getCardInfo'))), 8, '0', STR_PAD_LEFT);
						break;
						
						case 1:// baseFormatRfid 001A
						//преобразование длинного десятичного числа к 001A
							$key=Model::Factory('Stat')->decDigitTo001A(Arr::get($post, 'getCardInfo'));
						break;
					
					}
				}
				
			break;
			case 'hex':	// номер для поиска передан в формате hex		
				
					 //echo Debug::vars('144 число HEX');
						//Номер передан в формате HEX	
							 $post=Validation::factory($this->request->post());
							 $post->rule('getCardInfo', 'not_empty')
									->rule('getCardInfo', 'regex', array(':value', '/^[a-fA-F0-9]+$/'));
											;
							if($post->check())// номер передан в формате hex
							{
								//echo Debug::vars('147 001A');exit;
								$key=Arr::get($post, 'getCardInfo');
								switch(Kohana::$config->load('artonitcity_config')->baseFormatRfid){
									case 0: //baseFormatRfid hex8
									//преобразование HEX к HEX. Добавляю слева нули, чтобы длина была 8 символов.
										
										$key = STR_PAD(Arr::get($post, 'getCardInfo'), 8, '0', STR_PAD_LEFT);
									break;
									
									case 1:// baseFormatRfid 001A
									//преобразование HEX к 001A
										$key=Model::Factory('Stat')->decDigitTo001A(hexdec(Arr::get($post, 'getCardInfo')));// пребразую HEX в DEC, а затем использую готовую функцию.
									break;
								}
							
							}

			break;
			case 'none':
				$key=Arr::get($post, 'getCardInfo');
			
			break;
			default:
				$this->redirect('people/find');
			break;
						
		}		
		//echo Debug::vars('160 STOP', $key);exit;
		
		if($key!='')
		{
			//Получаю ID_PEP по номеру карты
			$id_pep_array=Model::factory('People')->getIdPepFromCard($key);
			//echo Debug::vars('171', $id_pep, $key);exit;
			
			$_SESSION['peopleEventsTimeFrom']=Arr::get($_GET, 'timeFrom', Date::formatted_time('-2 days', "d.m.Y H:i:s"));
			$_SESSION['peopleEventsTimeTo']=Arr::get($_GET, 'timeTo',Date::formatted_time('now', "d.m.Y H:i:s"));
			$id_pep=null;
			if(is_array($id_pep_array))
			{
				foreach($id_pep_array as $key=>$value)
				{
					$id_pep[Arr::get($value, 'ID_PEP')]=Arr::get($value, 'ID_PEP');
				}
		
			}
			//echo Debug::vars('200', $result);exit;
			$result=Model::Factory('People')->findIdPepInfo($id_pep);// поиск ID жильцов по указанном ID_PEP
			if(count($result)>0)
			 {
				$content=View::Factory('people/select', array(
				'list' => $result,
				));
			 $this->template->content = $content;
			 
			 } else {
			 $content=View::Factory('people/search');
			 $this->template->content = $content;
			 }
		 } else {
			 //echo Debug::vars('108', $param->errors());exit;
			  $content=View::Factory('people/search');
			 $this->template->content = $content;
		 }
			
	}
		
	 
	 
	
	
	public function action_card_late_save_to_file()
	{
		Model::Factory('stat')->card_late_save_to_file();
		$content =Model::Factory('Log')->send_file(Kohana::find_file('downloads','Late_card_befor', 'csv'));		
		$this->template->content = $content;
	}
	
	public function action_card_late_next_week_save_to_file()
	{
		Model::Factory('stat')->card_late_next_week_save_to_file();
		$content =Model::Factory('Log')->send_file(Kohana::find_file('downloads','Late_card_next_week', 'csv'));		
		$this->template->content = $content;
	}
	
	
	public function action_find_card_late()
	{
		$t1=microtime(1);
		$result=Model::Factory('stat')->Get_people_late();
		$t2=microtime(1);
		$this->set_full_width(true);
		$content=View::Factory('people/card_late', array(
			'list' => $result,
			'delay'=>$t2-$t1,
			'title'=>'card_late_info'
			
		));
		$this->template->content = $content;
		//echo View::factory('profiler/stats');
	}
	
		public function action_find_unActiveCard()
	{
		$t1=microtime(1);
		$result=Model::Factory('people')->Get_unActiveCard();
		$t2=microtime(1);
		$content=View::Factory('people/card_late', array(
			'list' => $result,
			'delay'=>$t2-$t1,
			'title'=>'unActiveCard'
		));
		$this->template->content = $content;
		//echo View::factory('profiler/stats');
	}
	
	
	public function action_find_card_late_next_week()
	{
		$result=Model::Factory('stat')->Get_people_late_next_week();
	
			$content=View::Factory('people/card_late_next_week', array(
			'list' => $result,
			));
		 $this->template->content = $content;
		 
		 
	}
	
	
	public function action_peopleInfo($id_pep=false)//подготовка информации по выбранному пользователю
	{
			//$this->set_full_width(true);
			$id_pep = $this->request->param('id');
			$id_card = $this->request->param('card');
			$_SESSION['menu_active']='people';
			//echo Debug::vars('44 peopleInfo', 'POST:', $_POST, 'GET:', $_GET,'id_pep:',  $id_pep, 'SESSION:', $_SESSION); exit;
			if ($id_pep == NULL) $this->redirect('people/find');
			$people_data=Model::Factory('People')->getPeople($id_pep, $id_card);//персональные данные
			$people_event=Model::Factory('Event') -> event_people($id_pep, $id_card);//события по пользователю за последние 24 часа.
			$people_parking=Model::Factory('Parking') -> event_people($id_pep);//Информация о нахождении на парковке
			$people_parking_errors=Model::Factory('Parking') -> parking_error($id_pep);//Информация о нарушениях парковки
			//echo Debug::vars('125', $people_data, $id_pep); exit;
		/* $content=View::Factory('people/view', array(
			'contact'	=> $people_data,
			'doors'	=> $people_door,
			'events'	=> $people_event,
			'parking'	=> $people_parking,
			'people_parking_errors'	=> $people_parking_errors,
			
			)); */
			
			    // Получаем категории доступа
    $people_access_categories = Model::Factory('People')->getPeopleAccessCategories($id_pep);
    
    // НОВЫЙ КОД: Получаем точки прохода
    $people_access_devices = Model::Factory('People')->getPeopleAccessDevices($id_pep);
    
    $content = View::Factory('people/view', array(
        'contact' => $people_data,
        'events' => $people_event,
        'parking' => $people_parking,
        'people_parking_errors' => $people_parking_errors,
        'access_categories' => $people_access_categories,
        'access_devices' => $people_access_devices, // НОВАЯ ПЕРЕМЕННАЯ
    ));
			
		$this->template->content = $content;
	}
	
	public function action_people_without_card()//список пользователей без карты 
	{
		$people_without_card=Model::Factory('People')->getPeople_without_card();
		$content=View::factory('people/people_without_card', array(
				'list'=>$people_without_card,
		));
		$this->template->content = $content;
	}
	
	
	public function action_people_without_card_delete()//Удаление указанных пользователй без карты
	{
		$people_for_del=Arr::get($_POST, 'id_pep');
		Log::instance()->add(Log::NOTICE, 'Удадлены пользователи :user', array(
				'user' => implode(",",$people_for_del),
				));
		Model::Factory('People')->People_delete($people_for_del);//удаление указанних пользователей
		//echo Debug::vars('131', $_SESSION, $_POST, $people_for_del); exit;	
		$this->redirect('/');
	}
	
	
	public function action_people_without_events()//список пользователей без событий в журнале событий
	{
		$people_without_card=Model::Factory('People')->getPeople_without_events();
		$content=View::factory('people/people_without_events', array(
				'list'=>$people_without_card,
		));
		$this->template->content = $content;
	}
	
	
	/**
 * Обработка действий с картами (удаление, деактивация)
 * Принимает POST запросы от формы в _table.php
 */
public function action_control()
{
      
    $todo = Arr::get($_POST, 'todo');
    $id_cards = Arr::get($_POST, 'id_pep', array());
   echo Debug::vars('350', $_POST);exit; 
    // Обрабатываем id_cards - убираем лишние кавычки, если они есть
    if (is_array($id_cards)) {
        $id_cards = array_map(function($card) {
            return trim($card, "'");
        }, $id_cards);
        $id_cards = array_filter($id_cards);
    } else {
        $id_cards = array();
    }
    
    if (empty($id_cards)) {
        Kohana::$log->add(Log::INFO, 'action_control: Не выбрано ни одной карты для операции');
        $this->redirect('people/find_card_late');
        return;
    }
    
    Kohana::$log->add(Log::INFO, 'action_control: Выполняется операция :todo для :count карт', array(
        ':todo' => $todo,
        ':count' => count($id_cards)
    ));
    
    switch ($todo) {
        case 'unactive':
            // Деактивация карт
            $this->card_unactive($id_cards);
            break;
            
        case 'delete':
            // Удаление карт
            $this->card_delete_action($id_cards);
            break;
            
        default:
            Kohana::$log->add(Log::WARNING, 'action_control: Неизвестная операция :todo', array(':todo' => $todo));
            break;
    }
    
    // Возвращаемся на страницу, с которой пришли
    $redirect_url = Arr::get($_POST, 'redirect_url', 'people/find_card_late');
    $this->redirect($redirect_url);
}

/**
 * Деактивация карт по ID карт
 * @param array $id_cards Массив ID карт
 */
private function card_unactive($id_cards)
{
    if (empty($id_cards)) {
        return;
    }
    
    try {
        Model::Factory('People')->card_people_unactive($id_cards);
        Kohana::$log->add(Log::INFO, 'card_unactive: Деактивировано :count карт', array(':count' => count($id_cards)));
    } catch (Exception $e) {
        Kohana::$log->add(Log::ERROR, 'card_unactive: Ошибка при деактивации карт: :error', array(':error' => $e->getMessage()));
    }
}

	/**
	 * Удаление карт по ID карт
	 * @param array $id_cards Массив ID карт
	 */
	private function card_delete_action($id_cards)
	{
		if (empty($id_cards)) {
			return;
		}
		
		try {
			Model::Factory('People')->card_Card_delete($id_cards);
			Kohana::$log->add(Log::INFO, 'card_delete_action: Удалено :count карт', array(':count' => count($id_cards)));
		} catch (Exception $e) {
			Kohana::$log->add(Log::ERROR, 'card_delete_action: Ошибка при удалении карт: :error', array(':error' => $e->getMessage()));
		}
	}

/**
 * Поиск по категориям доступа
 * Показывает список категорий и сотрудников, имеющих выбранные категории
 */
public function action_access_search()
{
    $_SESSION['menu_active'] = 'people';
	//$this->set_full_width(true);
    
    // Получаем все категории доступа с количеством сотрудников
    $access_names = Model::Factory('People')->getAccessNames();
    
    // Получаем выбранные категории из POST
    $selected_access = Arr::get($_POST, 'access_names', array());
    
    $people_list = array();
    if (!empty($selected_access)) {
        // Ищем сотрудников с выбранными категориями
        $people_list = Model::Factory('People')->getPeopleByAccess($selected_access);
    }
    
    $content = View::Factory('people/access_search', array(
        'access_names' => $access_names,
        'selected_access' => $selected_access,
        'people_list' => $people_list,
    ));
    
    $this->template->content = $content;
}


/**
 * Экспорт результатов поиска по категориям доступа в CSV
 */
public function action_access_export()
{
    // Получаем ID выбранных категорий из POST
    $access_ids = Arr::get($_POST, 'access_names', array());
    
    if (empty($access_ids)) {
        Kohana::$log->add(Log::WARNING, 'Попытка экспорта без выбранных категорий доступа');
        $this->redirect('people/access_search');
        return;
    }
    
    // Получаем данные для экспорта
    $people_list = Model::Factory('People')->getPeopleByAccess($access_ids);
    
    if (empty($people_list)) {
        Kohana::$log->add(Log::INFO, 'Экспорт: нет данных для выбранных категорий');
        $this->redirect('people/access_search');
        return;
    }
    
    // Формируем CSV
    $filename = 'access_export_' . date('Y-m-d_H-i-s') . '.csv';
    $delimiter = ';'; // Для Excel лучше использовать ;
    
    // Заголовки CSV
    $headers = array(
        'ID',
        'Фамилия',
        'Имя',
        'Отчество',
        'Организация',
        'Категории доступа',
        'Кол-во категорий',
        'Примечание'
    );
    
    // Устанавливаем заголовки для скачивания
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    // Открываем поток вывода
    $output = fopen('php://output', 'w');
    
    // Добавляем BOM для корректного отображения UTF-8 в Excel
    fwrite($output, "\xEF\xBB\xBF");
    
    // Записываем заголовки
    fputcsv($output, $headers, $delimiter);
    
    // Записываем данные
    foreach ($people_list as $person) {
        $row = array(
            $person['ID_PEP'],
            $person['SURNAME'],
            $person['NAME'],
            $person['PATRONYMIC'],
            $person['ORG_NAME'],
            $person['ACCESS_NAMES'],
            $person['ACCESS_COUNT'],
            $person['NOTE']
        );
        fputcsv($output, $row, $delimiter);
    }
    
    fclose($output);
    exit;
}


}
