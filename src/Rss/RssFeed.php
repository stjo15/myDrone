<?php

namespace Anax\Rss;
 
/**
 * Model for Rss.
 *
 */
class RssFeed extends \Anax\MVC\CDatabaseModel
{
    
    /**
    * Concatonate feed database details and items table.
    *
    * @param str $pagekey The key for the page of the feed (the last part of the page url) 
    *
    * @return str
    */
    public function getFeed($pagekey=null)
    {
        
    return $this->getRssDetails($pagekey) . $this->getItems($pagekey);
    
    }
	
    
    /**
    * Get feed database details table.
    *
    * @param str $pagekey The key for the page of the feed (the last part of the page url) 
    *
    * @return str
    */
	private function getRssDetails($pagekey) {
	    
	    $itemstable = "rssfeed";
		
		$res = $this->getValues($itemstable, $pagekey);
		
		$link =  $this->di->get('url')->create($pagekey);
		
		foreach ($res as $key => $detail) {
		    $key = (is_object($detail)) ? $detail->id : $key;
		    $detail = (is_object($detail)) ? get_object_vars($detail) : $detail;
		   
		// Default content of RSS tags if not set by user    
		$image_title = (strlen($detail['image_title']) > 0) ? $detail['image_title'] : $detail['title'];
		$image_url = (strlen($detail['image_url']) > 0) ? $detail['image_url'] : 'http://www.student.bth.se/~stjo15/phpmvc/kmom05/Stalles-Me-sida/webroot/img/rss.png';
		$image_link = (strlen($detail['image_link']) > 0) ? $detail['image_link'] : $link;
		$image_width = ($detail['image_width']) > 0 && ($detail['image_width'] < 144) ? $detail['image_width'] : 100;
		$image_height = ($detail['image_height']) > 0 && ($detail['image_height'] < 400) ? $detail['image_height'] : 100;
		    
		$details = '<?xml version="1.0" encoding="utf-8" ?>
				<rss version="2.0">
					<channel>
						<title>' . $detail['title'] . '</title>
						<link>' . $link . '</link>
						<description>' . $detail['description'] . '</description>
						<language>' . $detail['language'] . '</language>
						<image>
							<title>' . $image_title . '</title>
							<url>' . $image_url . '</url>
							<link>' . $image_link . '</link>
							<width>' . $image_width . '</width>
							<height>' . $image_height . '</height>
						</image>';
		};
		
		return $details;
	}
	
	
	/**
    * Get feed database items table, the 'articles' of the RSS feed. 
    * Set the database table from where you want the RSS feed to get data as the variable $itemstable. 
    * Change title, link and description tags CONTENT according to your own database content. 
    * The tags must remain as they are!
    *
    * @param str $pagekey The key for the page of the feed (the last part of the page url) 
    *
    * @return str
    */
	private function getItems($pagekey) {
	    
	    // The DB table from where you want to get the new RSS updates.
		$itemstable = "comment";
		
		$res = $this->getValues($itemstable, $pagekey);
		    
		$items = '';
		$link =  $this->di->get('url')->create($pagekey);
		
		foreach ($res as $key => $item) {
		    
		    $key = (is_object($item)) ? $item->id : $key;
		    $item = (is_object($item)) ? get_object_vars($item) : $item;
		    
		    //convert time to rfc822 format
		    $rfc822time = date('r', strtotime($item['timestamp']));
		    
			$items .= '<item>
				<title>' . $item['name'] . ' kommenterade ' . $item['pagekey'] . '</title>
				<link>' . $link .'</link>
				<description><![CDATA[' . $item['content'] . ']]></description>
				<pubDate>' . $rfc822time . '</pubDate>
			</item>';
		}
		
		$items .= '</channel>
				</rss>';
		return $items;
		
	}
	
	
	/**
    * Get values from a database table.
    *
    * @param str $table The table name from where you want to get the values.
    * @param str $pagekey The key for the page of the feed (the last part of the page url) 
    *
    * @return str
    */
	public function getValues($table, $pagekey) {
	
	     $all = $this->fromquery($table)
		    ->where('pagekey = ?')
		    ->execute([$pagekey]);
		    
		    return $all;
	}
	
	/**
    * Build a select-query with custom table.
    *
    * @param string $table which table to select from.
    * @param string $columns which columns to select.
    * 
    * @return $this
    */
    public function fromquery($table, $columns = '*')
    {
       $this->db->select($columns)
             ->from($table);
 
       return $this;
    }
    
    
    
}
 