<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Model_Menu extends Model_Base
{
	protected $_name = 'menu_item';

	protected function _getHeir(& $arr, $x, $parentId = 0)
	{
		$data = array();

		for ($i = 0; $i < $x; $i++) {
			if ($arr[$i]['parent_id'] == $parentId) {
				$data[] = array(
					'id' => $arr[$i]['id'],
					'parent_id' => $arr[$i]['parent_id'],
					'position' => $arr[$i]['position'],
					'label' => $arr[$i]['label'],
					'link' => $arr[$i]['link'],
					'submenu' => $this->_getHeir($arr, $x, $arr[$i]['id'])
				);
			}
		}

		if (empty($data))
			return 0;

		return $data;
	}

	/**
	 * 
	 */
	public function getMenu($id = 1)
	{
		$select = $this->select()
			->where('is_visible=1')
			->where('menu_id=?', $id)
			->order('parent_id')
			->order('position');
			

		$result = $this->fetchAll($select);
		
		if (is_object($result)) {
			$data = $result->toArray();
		} else {
			return 0;
		}

		$x = sizeof($data);
		$menu = $this->_getHeir($data, $x);

		return $menu;
	}
}

/* End of file application/model/Menu.php */
