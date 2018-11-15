<?php
//不需要登录即可访问

$GLOBALS['resultCode']=array(
						'SUCCESS'		=>		200,
						'FAILD'			=>		0,
                        'MISSPARAM'     =>      -1,
                        'NORIGHT'		=>		-2,
                        'UNLOGIN'		=>		-200,
);

//general
$GLOBALS['MenuGroup']=array(1=>'系统设置');
$GLOBALS['FunctionList']=array();
$GLOBALS['FunctionList']['admin.admin_list']=array('url'=>'index.php?controller=admin&method=admin_list','t'=>'帐号管理','is_m'=>true,'group'=>1,'game'=>array('*'));
$GLOBALS['FunctionList']['admin.add_admin']=array('url'=>'index.php?controller=admin&method=add_admin','t'=>'添加帐号','is_m'=>true,'group'=>1,'game'=>array('*'));
$GLOBALS['FunctionList']['admin.admin_edit']=array('url'=>'','t'=>'修改帐号','is_m'=>false,'group'=>1,'game'=>array('*'));
$GLOBALS['FunctionList']['admin.admin_delete']=array('url'=>'','t'=>'删除帐号','is_m'=>false,'group'=>1,'game'=>array('*'));
$GLOBALS['FunctionList']['admin.admin_group_list']=array('url'=>'index.php?controller=admin&method=admin_group_list','t'=>'帐号组管理','is_m'=>true,'group'=>1,'game'=>array('*'));
$GLOBALS['FunctionList']['admin.add_admin_group']=array('url'=>'index.php?controller=admin&method=add_admin_group','t'=>'添加帐号组','is_m'=>true,'group'=>1,'game'=>array('*'));
$GLOBALS['FunctionList']['admin.edit_admin_group']=array('url'=>'','t'=>'修改帐号组','is_m'=>false,'group'=>1,'game'=>array('*'));
$GLOBALS['FunctionList']['admin.delete_admin_group']=array('url'=>'','t'=>'修改帐号组','is_m'=>false,'group'=>1,'game'=>array('*'));


$GLOBALS['NoNeedPower']=array(
                        'index.login',
                        'index.logout',
                        'index.imgcode',
                        'index.selectedgame',
                        'ajax.loginstatus',
                        'ajax.login',
                        'ajax.logout',
						'ajax.getdata',
						'index.chgpwd'
                        );