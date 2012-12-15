<?php
/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class SearchController extends controllers_FrontedController
{
	protected $_path;
	
	public  function init()
	{
		parent::init();
		$this->_path =  $_SERVER['DOCUMENT_ROOT'] . '/../data/search';
		
		$analyzer = new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive();
		$analyzer->addFilter(new system_Phpmorphy());
		
		Zend_Search_Lucene_Analysis_Analyzer::setDefault($analyzer);
	}
	
	public function indexAction()
	{
		if ($this->_request->isPost()) {
			
/* 			if (file_exists($index = self::getLuceneIndexFile())) {
				return Zend_Search_Lucene::open($index);
			} */
			
			$index = Zend_Search_Lucene::open($this->_path);
			$keywords = $this->_request->getParam('query');
			$query = Zend_Search_Lucene_Search_QueryParser::parse($keywords);
			
			$hits = $index->find($query);
			
			$data = array();
			
			foreach ($hits as $hit) {
				$data[] = array(
				'id' => $hit->id,
				'link' => $hit->link,
				'header' => $hit->header,
				'anons' => $hit->anons
				);
			}
			
			$this->view->list = $data;
			$this->view->keywords = $keywords;
		} else {
			$this->view->list = null;
		}
	}
	
	public function buildAction()
	{
		$this->_clearDir();

        $this->_helper->viewRenderer->setNoRender(true);
        
		$index = Zend_Search_Lucene::create($this->_path);

		$model = new models_Page();
		$pages = $model->getPages();
		
		if (sizeof($pages) > 0) {
			foreach ($pages as $page) {
				$doc = new Zend_Search_Lucene_Document();	
				
				$doc->addField(Zend_Search_Lucene_Field::UnIndexed('id', $page['id']));
 				$doc->addField(Zend_Search_Lucene_Field::UnIndexed('link', $page['link']));
 				
 				$doc->addField(Zend_Search_Lucene_Field::UnStored('title', $page['title'], 'UTF-8'));
 				$doc->addField(Zend_Search_Lucene_Field::UnStored('content', strip_tags($page['content'], 'UTF-8')));
 				
				$doc->addField(Zend_Search_Lucene_Field::Text('header', $page['header'], 'UTF-8'));
				$doc->addField(Zend_Search_Lucene_Field::Text('anons', strip_tags($page['anons'], 'UTF-8')));

				$index->addDocument($doc);
			}
		}
		$index->optimize();
	}
	
	protected function _clearDir()
	{
		$handle = opendir($this->_path);

		while (FALSE !== ($item = readdir($handle))) {
			if ($item != '.' && $item != '..') {
				$path = $this->_path.'/'.$item;

				if (!is_dir($path)) {
					unlink($path);
				}
			}
		}
		closedir($handle);
	}
}

/* End of file application/controllers/SearchController.php */
