<?php
namespace Anax\MVC;

class CDatabaseModel implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


    public function getSource(){
        return strtolower(implode('', array_slice(explode('\\', get_class($this)), -1)));
    }

    public function selectFromWhere($from, $where){

        $this->db->select($this->getSource())
            ->from($from)
            ->where($where)
        ;
        return $this->db->execute([2]);

    }

    public function findAll() {

        $this->db->select()
            ->from($this->getSource());

        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();

    }

    public function lastInsertedId(){

        return $this->db->lastInsertId();
    }

    public function getProperties() {

        $properties = get_object_vars($this);
        unset($properties['di']);
        unset($properties['db']);
        unset($properties['usersTest11']);
        unset($properties['session']);
        unset($properties['questionModel']);

        return $properties;
    }


    public function find($id){
        $this->db->select()
            ->from($this->getSource())
            ->where("id = ?");

        $this->db->execute([$id]);
        return $this->db->fetchInto($this);

    }


    public function save($values = [])
    {
        $this->setProperties($values);
        $values = $this->getProperties();

        if (isset($values['id'])) {
            return $this->update($values);
        } else {
            return $this->create($values);
        }
    }


    public function setProperties($properties)
    {
        if (!empty($properties)) {
            foreach ($properties as $key => $val) {
                $this->$key = $val;
            }
        }
    }


    public function create($values)
    {
        $keys   = array_keys($values);
        $values = array_values($values);

        $this->db->insert(
            $this->getSource(),
            $keys
        );

        $res = $this->db->execute($values);

        $this->id = $this->db->lastInsertId();

        return $res;
    }

    public function update($values)
    {
        $keys   = array_keys($values);
        $values = array_values($values);

        // Its update, remove id and use as where-clause
        unset($keys['id']);
        $values[] = $this->id;

        $this->db->update(
            $this->getSource(),
            $keys,
            "id = ?"
        );

        return $this->db->execute($values);
    }


    public function delete($id)
    {
        $this->db->delete(
            $this->getSource(),
            'id = ?'
        );

        return $this->db->execute([$id]);
    }

    public function query($columns = '*')
    {
        $this->db->select($columns)
            ->from($this->getSource());

        return $this;
    }

    public function where($condition)
    {
        $this->db->where($condition);

        return $this;
    }


    public function andWhere($condition)
    {
        $this->db->andWhere($condition);

        return $this;
    }

    public function execute($params = [])
    {
        $this->db->execute($this->db->getSQL(), $params);
        //$this->db->setFetchModeClass('FETCH_NUM');
        return $this->db->fetchAll();
    }

    public function orderBy($condition){

        $this->db->orderBy($condition);

        return $this;
    }

    public function limit($condition){

        $this->db->limit($condition);

        return $this;
    }



    public function setup(){

    }

}


