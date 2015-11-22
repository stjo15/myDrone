<?php

namespace Anax\Question;
 
/**
 * Model for Questions.
 *
 */
class Question extends \Anax\MVC\CDatabaseModel
{
    
    public function findAll($tagslug=null, $orderby='timestamp DESC')
    {
    
    if (isset($tagslug)) {
        $all = $this->query()
        ->where("tagslug LIKE '%" . $tagslug . "%' ")
        ->orderBy($orderby)
        
        ->execute();
        
        return $all;
    } else {
        $this->db->select()
             ->from($this->getSource())
             ->orderBy($orderby);
             
             $this->db->execute();
             $this->db->setFetchModeClass(__CLASS__);
             return $this->db->fetchAll();
    }
    }

    public function findQuestion($tag=null, $id)
    {
        if (isset($tag) && isset($id)) {
            $all = $this->query()
                ->where('tag = ?')
                ->andWhere('id = ?')
                
                ->execute([$tag, $id]);
        
            return $all;
        } else {    
            $all = $this->query()
                ->where('id = ?')
                
                ->execute([$id]);
        
            return $all;
        }
    }
    
    public function findAllLimit($tagslug=null, $orderby='timestamp DESC', $limit)
    {
    
        $this->db->select()
             ->from($this->getSource())
             ->orderBy($orderby)
             ->limit($limit);
             
             $this->db->execute();
             $this->db->setFetchModeClass(__CLASS__);
             return $this->db->fetchAll();
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
    
    public function findUserIdFromTable($table, $userid)
    {
        $all = $this->fromquery($table)
             ->where('userid = ?') 
             ->execute([$userid]);
 
        return $all;
    }
    
    
}