<?php

/**
 * @author		go_first
 * @copyright	Copyright (c) 2011 Quality Case (http://www.qualitycase.ru/)
 * @package		miniCase
 * @version		0.91
 */

class FeedController extends Zend_Controller_Action
{
	public function init()
	{
		$this->_helper->viewRenderer->setNoRender(true);
	}
	
	private function getFeed()
	{
		$url = 'http://' . $_SERVER['HTTP_HOST'].'/';
		
		$feed = new Zend_Feed_Writer_Feed;
		$feed->setTitle('Название');
		$feed->setLink($url);
		$feed->setDateModified(time());
		$feed->setDescription('this is my blog');
		
		$model = new models_Page();
		$articlesLast10 = $model->getPages();
		
		foreach ($articlesLast10 as $item) {
			$entry = $feed->createEntry();

			$date = new Zend_Date($item['created'], 'YYYY-MM-dd HH:mm:ss');
			$itemTimestamp = $date->getTimestamp();
			
			$entry->setTitle($item['header']);
			$entry->setLink($url.$item['link'].'.html');
			$entry->setDateModified(time());
			$entry->setDateCreated($itemTimestamp);
			
			if (empty($item['anons'])) {
				$item['anons'] = '123';
			}
			
			$entry->setContent($item['anons']);
			
			$feed->addEntry($entry);
		}

		return $feed;
	}
	
	public function rssAction()
	{
		$feed = $this->getFeed();
		$feed->setFeedLink('http://' . $_SERVER['HTTP_HOST'] . '/feed/rss', 'rss');
	
		echo $feed->export('rss');
	}
	
	public function atomAction()
	{
		$feed = $this->getFeed();
		$feed->addAuthor("Jon Lebensold", "jon@lebensold.ca", "http://www.zendcasts.com");
		$feed->setFeedLink('http://' . $_SERVER['HTTP_HOST'] . 'feed/atom', 'atom');
	
		echo $feed->export('atom');
	}
}

/* End of file application/controllers/FeedController.php */