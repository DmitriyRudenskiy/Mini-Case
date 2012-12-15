<?php

/**
 * @author		Dmitriy Rudensky <cd_print@mail.ru>
 * @package		philharmonia.211.ru
 * @version		1.00
 */

class LogController extends Controller_Base
{
	protected $_controllerName = array(
    	0 => 'Категории',
    	1 => 'Комментарии',
    	2 => 'Композитор',
    	3 => 'Концерт',
    	4 => 'Дирижёр',
    	5 => 'Исполнитель',
    	6 => 'Изображение',
    	7 => 'Пользователи'
    );
    
    protected $_action = array(
    	'add' => 0,
    	'edit' => 1,
    	'delete' => 2,
    	'crop' => 3,
    	'hide' => 4,
    	'show' => 5,
    );
	
	protected function _setNames()
	{
		return array(
			'_model' => 'Model_Log'
		);
	}
	
	public function indexAction()
	{
		$number = (int)$this->getRequest()->getParam('id', 1);
		
		$config = Zend_Registry::get('config');
		
		$adapter = $this->_model->fetchPaginatorAdapter($this->_createForm());
		
		$paginator = new Zend_Paginator($adapter);
		$paginator->setItemCountPerPage($config['count']['pages']);
		$paginator->setCurrentPageNumber($number);
		
		$this->view->group = $paginator->getCurrentItems()->toArray();
		$this->view->navi = $paginator->getPages();
	}
	
	public function addAction()
	{
		
	}
	
	public function editAction()
	{

	}
	
	protected function _createForm()
	{
		$model = new Model_User();
		$listUsers = $model->getAllUsers();
		
		$options[0] = 'Все';
		$options[1] = 'root';
		foreach ($listUsers as $value) {
			$options[$value['id']] = $value['first_name'].' '.$value['last_name'];
		}
		
		$form = new Zend_Form();
		$element = new Zend_Form_Element_Select('user_id');
		$element->setAttrib('class', 'iselect')
			->setAttrib('onchange', 'this.form.submit()')
			->setMultiOptions($options)
			->addFilter('Int')
			->removeDecorator('Label')
			->removeDecorator('HtmlTag');
		$form->addElement($element);
		
		$this->view->form = $form;
		
		if ($this->getRequest()->isGet()) {
			$filter['user_id'] = (int)$this->getRequest()->getParam('user_id');
			$form->populate($filter);
			return $filter;
		}
		
		return null;

	}
	
	protected function _formatList(& $items)
    {
    	$x = sizeof($items);
    	for ($i = 0; $i < $x; $i++) {
    		$item = & $items[$i];
    		
    		$date = new Zend_Date($item['created'], false, 'ru_Ru');
    		$item['date'] = $date->toString("dd MMMM yyyy");
    		
    		$item['user_login'] = base64_decode($item['user_login']);
    		
    		$action = array_flip($this->_action);
    		$item['action'] = $action[$item['action_id']];
			
			$item['controller'] = $this->_controllerName[$item['controller_id']];

    	}

    }
}

/* End of file admin/controllers/CategoryController.php */
