<?php

namespace Anax\Answer;
 
/**
 * Model for Answers.
 *
 */
class Answer extends \Anax\MVC\CDatabaseModel
{
    
    public function findAll($pagekey=null)
    {
    
    if (isset($pagekey)) {
        $all = $this->query()
        ->where('pagekey = ?')
        ->execute([$pagekey]);
        
        return $all;
    }
    
    else {
        parent::findAll();
    }
    }

    public function findAnswer($pagekey=null, $id)
    {
    if (isset($pagekey) && isset($id)) {
        $all = $this->query()
        ->where('pagekey = ?')
        ->andWhere('id = ?')
        ->execute([$pagekey, $id]);
        
        return $all;
    }
    else {    
        $all = $this->query()
        ->where('id = ?')
        ->execute([$id]);
        
        return $all;
    }
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