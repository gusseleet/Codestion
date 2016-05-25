<?php
/**
 * Created by PhpStorm.
 * User: Gustav
 * Date: 2016-05-18
 * Time: 19:11
 */

namespace gel\Questions;


class tagsConnectedToQuestions extends \Anax\MVC\CDatabaseModel
{

    use \Anax\DI\TInjectable;

    public function getActiveTags(){


        $data = $this->findAll();
        foreach($data as $single)
            $ids[] = $single->idTag;


        $possibleTags = [
            'nada',
            'php',
            'c++',
            'Java',
            'JavaScript',
            'Python',
            'C#',
        ];

        $tagName = null;
       for($i = 0; $i < sizeof($ids); $i++){
           for($k = 0; $k < sizeof($possibleTags); $k++){
               if($ids[$i] == $k)
                   $tagName[] = $possibleTags[$k];
           }
       }



        return array_unique($tagName);

    }


    public function getTagsLimit($i){

        $sql = "SELECT       `idTag`,
             COUNT(`idTag`) AS `value_occurrence`
    FROM     `phpmvc_kmom04_tagsconnectedtoquestions`
    GROUP BY `idTag`
    ORDER BY `value_occurrence` DESC
    LIMIT    3;";


        $res = $this->db->executeFetchAll($sql);
        if(empty($res))
            return null;


        $tagOne = $this->db->executeFetchAll("SELECT _name FROM phpmvc_kmom04_tags WHERE id =" . $res[0]->idTag);
        $tagTwo = $this->db->executeFetchAll("SELECT _name FROM phpmvc_kmom04_tags WHERE id =" . $res[1]->idTag);
        $tagThree = $this->db->executeFetchAll("SELECT _name FROM phpmvc_kmom04_tags WHERE id =" . $res[2]->idTag);

        $values = [
            $tagOne[0]->_name,
            $tagTwo[0]->_name,
            $tagThree[0]->_name,
        ];


        return $values;

    }


}