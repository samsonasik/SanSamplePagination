<?php

namespace SanSamplePagination\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Requesthelper extends AbstractHelper
{
    protected $request;
    
    public function setRequest($request)
    {
        $this->request = $request;    
    }
    
    public function getRequest()
    {
        return $this->request;    
    }
    
    public function __invoke($str = 'QUERY_STRING')
    {
        return $this->getRequest()->getServer()->get($str);  
    }
}