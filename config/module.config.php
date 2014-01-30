<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'SanSamplePagination\Controller\Tablesample' => 'SanSamplePagination\Controller\TablesampleController',
        ),
    ), 
    
    'router' => array(
        'routes' => array( 
           
            'SanSamplePagination' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/samplepagination',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'SanSamplePagination\Controller',
                        'controller'    => 'tablesample',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller'    => 'tablesample',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                    
                    'pager' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/tablesample[/:page]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller'    => 'tablesample',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                    
                    'sample-id' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller[/:action[/:id[/]]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller'    => 'tablesample',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                    
                ),
            ),
        ),
    ),
    
    'view_helpers' => array(
        'factories' => array(
            'Requesthelper' => 'SanSamplePagination\View\Helper\Factory\RequestHelperFactory',
        )
    ),
    
   
    'view_manager' => array(
        'template_path_stack' => array(
            'SanSamplePagination' => __DIR__ . '/../view',
        ), 
    ),
    
);
