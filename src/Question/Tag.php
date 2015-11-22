<?php

namespace Anax\Question;
 
/**
 * Model for Questions.
 *
 */
class Tag extends \Anax\MVC\CDatabaseModel
{
    public function findTag($tagslug)
    {
            $all = $this->query()
                ->where('slug = ?')
                
                ->execute([$tagslug]);
        
            return $all;
    }
    
    public function findAll($orderby='questions DESC', $limit=null)
    {
        if(isset($limit)) {
            $all = $this->query()
                ->orderBy($orderby)
                ->limit($limit)
                
                ->execute();
        
            return $all;
        } else {
            $all = $this->query()
                ->orderBy($orderby)
                
                ->execute();
        
            return $all;
        }
    }
    
}