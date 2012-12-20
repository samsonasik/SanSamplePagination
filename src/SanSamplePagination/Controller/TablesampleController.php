<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/SanSamplePagination for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SanSamplePagination\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SanSamplePagination\Form\SampleForm;
use SanSamplePagination\Model\Sample;
  
class TablesampleController extends AbstractActionController
{
    protected $sampletable;
    public $viewmodel; 
    
    public function indexAction()
    { 
        
        $viewmodel = new ViewModel;
         
        $matches = $this->getEvent()->getRouteMatch();
        $page      = $matches->getParam('page', 1);

        
        $arrayAdapter = new \Zend\Paginator\Adapter\ArrayAdapter(  $this->getSampleTable()->fetchAll() );
        $paginator = new \Zend\Paginator\Paginator($arrayAdapter);

        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(2);
        
        
        $viewmodel->setVariable('sample', $paginator);
        
        return array(
            'sample'  => $paginator,
        );
    }
    
    public function editAction()
    {
        $id = (int) $this->params('id', 0); 
        if (!$id) {
            return $this->redirect()->toRoute('SanSamplePagination/default', array(
                'controller' => 'tablesample',
                'action'     => 'index',
            ));
        }
        
        $sampleTable = $this->getSampleTable()->getSampleById($id);
        
         
        $form  = new SampleForm();
        $form->bind($sampleTable);
        $form->get('submit')->setAttribute('value', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $sample = new Sample();
            $form->setInputFilter($sample->getInputFilter());
             
            $form->setData($request->getPost());
             if ($form->isValid()) {
                $this->getSampleTable()->saveSample($form->getData());
                 
                // Redirect to list of samples
                return $this->redirect()->toRoute('SanSamplePagination/default', array(
                    'controller' => 'tablesample',
                    'action'     => 'index',
                ));
            }
        } 
        
        return array(
            'form' => $form,
            'id' => $id
        );
    }
    
    public function addAction()
    {     
        $form  = new SampleForm();

        
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $sample = new Sample();
            $form->setInputFilter($sample->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                
                $sample->exchangeArray($form->getData());
                
                 
                $this->getSampleTable()->saveSample($sample);
               
               
                // Redirect to list of samples
                return $this->redirect()->toRoute('SanSamplePagination/default', array(
                    'controller' => 'tablesample',
                    'action'     => 'index',
                ));
            }
        }
        
        return array(
            'form' => $form,
        );
    }
    
    public function deleteAction()
    {
        $id = (int) $this->params('id', 0); 
        if (!$id) {
            return $this->redirect()->toRoute('SanSamplePagination/default', array(
                'controller' => 'tablesample',
                'action'     => 'index',
            ));
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getSampleTable()->deleteSample($id);
            }

            // Redirect to list of samples
            return $this->redirect()->toRoute('SanSamplePagination/default', array(
                'controller' => 'tablesample',
                'action'     => 'index',
            ));
        }

        return array(
            'id'    => $id,
            'sample' => $this->getSampleTable()->getSampleById($id)
        );
    }
    
    public function getSampleTable()
    {
        if (!$this->sampletable){
            $this->sampletable = $this->getServiceLocator()->get('SanSamplePagination\Model\SampleTable');
        }
        return $this->sampletable;
    }
}
