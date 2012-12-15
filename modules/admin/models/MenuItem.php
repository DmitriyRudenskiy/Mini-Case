<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class Model_MenuItem extends Model_Base
{
	protected $_name = 'menu_item';

	public function attributeLabels()
	{
		return array(
			'is_visible' => 0,
			'position' => 0,
			'menu_id' => 0,
			'parent_id' => 0,
			'label' => 0,
			'link' => 0
		);
	}
	
	public function getItems()
	{
		$data = $this->fetchAll();
		
		if (is_object($data)) {
			return $data->toArray();
		}
		
		return 0;
	}

	public function getGroupItem($id = 0)
   	{
        $select = $this->select()
            ->where('menu_id=?', $id);
       
       $result = $this->fetchAll($select);
       
       if(is_object($result))
            return $result->toArray();
	}
	
	public function moveUp($itemId)
	{
		$row = $this->find($itemId)->current();
		if($row) {
			$position = $row->position;
			if($position < 1) {
				// this is already the first item
				return FALSE;
			}else{
				//find the previous item
				$select = $this->select()
					->order('position DESC')
					->where("position < ?", $position)
					->where("menu_id = ?", $row->menu_id);
				$previousItem = $this->fetchRow($select);
				if($previousItem) {
					//switch positions with the previous item
					$previousPosition = $previousItem->position;
					$previousItem->position = $position;
					$previousItem->save();
					$row->position = $previousPosition;
					$row->save();
				}
			}
		} else {
			throw new Zend_Exception("Error loading menu item");
		}
	}
	
	public function moveDown($itemId)
	{
		$row = $this->find ( $itemId )->current ();
		if ($row) {
			$position = $row->position;
			if ($position == $this->_getLastPosition ( $row->menu_id )) {
				// this is already the last item
				return FALSE;
			} else {
				//find the next item
				$select = $this->select ();
				$select->order ( 'position ASC' );
				$select->where ( "position > ?", $position );
				$select->where("menu_id = ?", $row->menu_id);
				$nextItem = $this->fetchRow ( $select );
				if ($nextItem) {
					//switch positions with the next item
					$nextPosition = $nextItem->position;
					$nextItem->position = $position;
					$nextItem->save ();
					$row->position = $nextPosition;
					$row->save ();
				}
			}
		} else {
			throw new Zend_Exception ( "Error loading menu item" );
		}
	}
	
	public function moveAction() {
		$id = $this->_request->getParam ( 'id' );
		$direction = $this->_request->getParam ( 'direction' );
	
		$mdlMenuItem = new Model_MenuItem ( );
		$menuItem = $mdlMenuItem->find ( $id )->current ();
		if ($direction == 'up') {
			$mdlMenuItem->moveUp ( $id );
		} elseif ($direction == 'down') {
			$mdlMenuItem->moveDown ( $id );
		}
		$this->_request->setParam ( 'menu', $menuItem->menu_id );
		$this->_forward ( 'index' );
	}
}

/* End of file admin/models/MenuItem.php */