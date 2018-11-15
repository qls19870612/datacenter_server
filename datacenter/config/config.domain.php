<?php

/**
  * DOMAIN_LIMIT
  * 
  * 通过域名进行访问控制,如果关闭限制功能,则所有访问只要控制器存在,或模块存在,就可以直接生效.控制器访问权限可以使用"*"号进行泛匹配,
  *
  * @var String DOMAIN_LIMIT
 */
$GLOBALS['DOMAIN_LIMIT']=array(
							'ENABLE_DOMAIN_LIMIT'	=>	FALSE,
							'DOMAIN'				=>	'hiphper.cc',
							'ALLOW_SUB_DOMAIN'		=>	'giraffe,www,',
							'ALLOW_CONTROLLER'		=>	array(
															'giraffe'=>array('*'),
															'www'=>array(
																		'index'=>array('*'),
																		'article'=>array('list','view')
																		)
															),
							'ALLOW_FINGER_MODEL'	=>	array(
															'giraffe'=>array('User'=>array('Login','Logout'),
																			'Article'=>array('list','*'),
																			),
															'www'=>array('*')
															)
							);



