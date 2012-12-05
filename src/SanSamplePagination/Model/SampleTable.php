<?php

namespace SanSamplePagination\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
 

class SampleTable extends AbstractTableGateway
    implements \Zend\Db\Adapter\AdapterAwareInterface
{
    protected $table = 'sampletable';
    
    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
         
        $this->resultSetPrototype->setObjectPrototype(new Sample());
        $this->initialize();
    }
    
      
    
    public function fetchAll($query = 0)
    {   
        $resultSet = $this->select(function (Select $select){
            $select->columns(array('id', 'name', 'gender'));
             $select->order(array('id asc'));  
        });
        
        $resultSet->buffer();
        $resultSet->next();
        
        $resultSet = $resultSet->toArray();
        
        return $resultSet; 
    }  
     
    
    public function getSampleById($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
    public function saveSample(Sample $sample)
    {
        $data = array(
            'name' => $sample->name,
            'gender' => $sample->gender,
            'hobby' => \Zend\Json\Json::encode($sample->hobby),
            'email'   => $sample->email,
            'birth' => $sample->birth,
            'address' => $sample->address,
            'direction' => $sample->direction
        );
        $id = (int)$sample->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getSampleById($id)) {
                
                $this->update($data, array('id' => $id));
            
            } else {
                throw new \Exception('Form id does not exist');
            }
        } 
        
    }
    
    public function deleteSample($id)
    {
        $this->delete(array('id' => $id));

    }
}