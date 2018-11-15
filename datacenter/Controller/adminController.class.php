<?php
class adminController extends BasicController
{
    private $controller = 'admin';


    //帐号管理
    function admin_list()
    {
        $kw = _request('kw');
        $page = intval(_request('page')) ? intval(_request('page')) : 1;
        $user =new admin();

        $result = $user->getList($kw, $page, 20, 'id desc');


        foreach ($result as $k => $v) {
            $this->Viewer->assign($k, $v);
        }
        $this->Viewer->assign('page_str', pagestr($result['count'], $result['page'], 20, $paramkey = array('controller', 'method', 'kw')));

        $p = _REQUEST();
        foreach ($p as $k => $v) {
            $this->Viewer->assign($k, $v);
        }
        //$this->db->debug();
        $this->Viewer->display('admin/admin_list');
    }


    //添加管理员帐号
    function add_admin()
    {
        $admin = new admin();
   		$GAME_LIST=$admin->getGameList();
		$PLATFORM=array();
		if($GAME_LIST){
			$plt='';
			foreach($GAME_LIST as $game){
				$plt.=$game['pltlist'].',';
			}
			$PLATFORM=array_unique(explode(',',$plt));
		}

        $this->Viewer->assign('GAME_LIST', $GAME_LIST);
        $this->Viewer->assign('PLATFORM', $PLATFORM);
        $grouplist = $admin->admin_group_list();

        $this->Viewer->assign('grouplist', $grouplist);

        $p = _post();
        if (isset($p['saveedit']) && $p['saveedit'] == 1) {
            $result = array('status' => false, 'msg' => '');
            if (!isset($p['username']) || !preg_match("/^[a-zA-z][a-zA-Z0-9]{2,}/is", trim($p['username']))) {
                $result['msg'] = '用户名不正确1';
            } elseif (!isset($p['pwd']) || strlen($p['pwd']) < 6 || !isset($p['repwd']) || $p['repwd'] != $p['pwd']) {
                $result['msg'] = '密码不正确,或重复密码不正确,请检查2';

            } elseif (!isset($p['realname']) || $p['realname'] == '') {
                $result['msg'] = '请填写真实姓名3';

            } else {
                if ($admin->check('name', $p['username'])) {
                    $result['msg'] = '该用户名已存在,不能重复4';

                } elseif (!$p['level'] && (!isset($p['group']) || !$p['group'])) {
                    $result['msg'] = '请选择最少一个权限组给用户5';

                } else {
                    $arr['name'] = safestr(trim($p['username']));
                    $arr['password'] = md5(md5($p['pwd']));
                    $arr['realname'] = safestr($p['realname']);
                    $arr['stop'] = intval($p['stop']);
                    $arr['level'] = intval($p['level']);
                    $allowgame = _post('allowgame');
                    $allowplatform = _post('allowplatform');
                    if ($allowgame) {
                        $arr['AllowGame'] = implode(',', $allowgame);
                    }
                    if ($allowplatform) {
                        $arr['AllowPlatform'] = implode(',', $allowplatform);
                    }

                    if (!intval($p['level'])) {
                        $arr['group_ids'] = implode(',', $p['group']);
                    }
                    $arr['pid'] = safestr($_SESSION['admin']['id']);


                    if ($admin->add_user($arr)) {
                        $result['status'] = true;

                    } else {
                        $result['msg'] = '保存时出错6';

                    }
                }

            }
            echo json_encode($result);
            die();
        }


        $this->Viewer->display('admin/add_admin');
    }

    //编辑修改管理员帐号
    function admin_edit()
    {
        $admin = new admin();
		$GAME_LIST=$admin->getGameList();
		$PLATFORM=array();
		if($GAME_LIST){
			$plt='';
			foreach($GAME_LIST as $game){
				$plt.=$game['pltlist'].',';
			}
			$PLATFORM=array_unique(explode(',',$plt));
		}

        $this->Viewer->assign('GAME_LIST', $GAME_LIST);
        $this->Viewer->assign('PLATFORM', $PLATFORM);

        $id = intval(_request('id'));
        if (!$id) {
            $this->tips('请选择要编辑的帐号', 'index.php?controller=admin&method=admin_list');
        }

        $info = $admin->getUserInfo($id);
        if ($info['status'] != 1) {
            $this->tips('用户不存在', 'index.php?controller=admin&method=admin_list');
        }

        if ($info['userinfo']['id'] == $_SESSION['admin']['id'] && $info['userinfo']['level'] != 1) {
            $this->tips('您不能修改自己的帐号内容', 'index.php?controller=admin&method=admin_list');
        }
        if ($info['userinfo']['level'] == 1 && $_SESSION['admin']['level'] != 1) {
			$this->tips('您不能修改管理员级的帐号', 'index.php?controller=admin&method=admin_list');
        }
        $grouplist = $admin->admin_group_list();

        $this->Viewer->assign('grouplist', $grouplist);
        $p = _post();
        if (isset($p['saveedit']) && $p['saveedit'] == 1) {
            $result = array('status' => false, 'msg' => '');
            if (isset($p['pwd']) && $p['pwd'] != '' && (strlen($p['pwd']) < 6 || !isset($p['repwd']) || $p['repwd'] != $p['pwd'])) {
                $result['msg'] = '新密码不正确';


            } elseif (!isset($p['realname']) || $p['realname'] == '') {
                $result['msg'] = '请填写真实姓名';

            } else {
                if (!$p['level'] && (!isset($p['group']) || !$p['group'])) {
                    $result['msg'] = '请选择最少一个权限组给用户';


                } else {
                    if (isset($p['pwd']) && $p['pwd']) {
                        $arr['password'] = md5(md5($p['pwd']));
                    }

                    $arr['realname'] = safestr($p['realname']);
                    $arr['stop'] = intval($p['stop']);
                    $arr['level'] = intval($p['level']);
                    $allowgame = _post('allowgame');
                    $allowplatform = _post('allowplatform');
                    if ($allowgame) {
                        $arr['AllowGame'] = implode(',', $allowgame);
                    }
                    if (!intval($p['level'])) {
                        $arr['group_ids'] = implode(',', $p['group']);
                    }
                    if ($allowplatform) {
                        $arr['AllowPlatform'] = implode(',', $allowplatform);
                    }


                    if ($admin->update_user($arr, 'id=' . $id)) {
                        $result['status'] = true;

                    } else {
                        $result['msg'] = '保存时出错';

                    }
                }
            }
            echo json_encode($result);
            die();
        }

        $info['userinfo']['grouplist'] = explode(',', $info['userinfo']['group_ids']);
        $info['userinfo']['AllowGame'] = explode(',', $info['userinfo']['AllowGame']);
        $info['userinfo']['AllowPlatform'] = explode(',', $info['userinfo']['AllowPlatform']);
        $this->Viewer->assign('info', $info['userinfo']);
        $this->Viewer->display('admin/admin_edit.php');
    }

    //删除管理员帐号
    function admin_delete()
    {
        $id = intval(_request('id'));
        if (!$id) {

            $this->tips('请选择要删除的管理员帐号', 'index.php?controller=admin&method=admin_list');
        }
        $admin = new admin();
        $info = $admin->getUserInfo($id);
        if ($info['status'] != 1) {

            $this->tips('要删除的管理员帐号不存在', 'index.php?controller=admin&method=admin_list');
        }
        if ($info['userinfo']['level'] > $_SESSION['admin']['level']) {


            $this->tips('您的帐号没有权限删除超级管理员帐号', 'index.php?controller=admin&method=admin_list');
        }
        if ($id == $_SESSION['admin']['id']) {

            $this->tips('您不能删除自己的帐号', 'index.php?controller=admin&method=admin_list');
        }
        $admin->del_user($id);

        $this->tips('删除成功', 'index.php?controller=admin&method=admin_list');
    }

    function admin_group_list()
    {
        $kw = _request('kw');
        $page = intval(_request('page')) ? intval(_request('page')) : 1;
        $admin = new admin();
        $result = $admin->getGrouplist($kw, $page, 20);
        foreach ($result as $k => $v) {
            $this->Viewer->assign($k, $v);
        }
        $this->Viewer->assign('page_str', pagestr($result['count'], $result['page'], 10, $paramkey = array('controller', 'op', 'kw')));
        $this->Viewer->display('admin/admin_group_list');
    }


    function edit_admin_group()
    {
		$FunctionList=Cfg::G('FunctionList');
		$MenuGroup=Cfg::G('MenuGroup');

		$tmp_group=$this->_db->fetchAll("select id,groupname,parent_id from menu_group");
		$layout=$this->_db->fetchAll("select * from report_layout");
		$tmp=array();
		if($tmp_group){
			foreach($tmp_group as $v){
				$tmp[$v['id']]=$v;
				$tmp[$v['id']]['sub_group']=array();
				$tmp[$v['id']]['menu']=array();
				foreach($layout as $l){
					if($l['rp_mark']==$v['id']){
						$tmp[$v['id']]['menu'][]=$l;
					}
				}
			}
		}

		$report_power=$tmp;
		$tmp=null;
		
        $id = intval(_request('id'));
        if (!$id) {
            $this->tips('请选择要修改的权限组', 'index.php?controller=admin&method=admin_group_list');
        }
        $admin = new admin();
        $info = $admin->admin_group_list($id);
        if (!$info) {
            $this->tips('请选择要修改的权限组', 'index.php?controller=admin&method=admin_group_list');
        }
        $p = _post();
        if (isset($p['saveedit']) && $p['saveedit'] == 1) {
            if ($p['name'] == '') {


                $this->Viewer->assign('errmsg', '请填写权限组名称');
            } elseif (!isset($p['power']) || !is_array($p['power']) || !count($p['power'])) {

                $this->Viewer->assign('errmsg', '请选择权限');
            } else {
                $getGroup = $admin->getGroupByName($p['name']);
                if ($getGroup && $getGroup['id'] != $id) {

                    $this->Viewer->assign('errmsg', '该权限名称已存在,不能重复');
                } else {
                    $arr['name'] = $p['name'];
                    $arr['power'] = implode(',', $p['power']);
                    if ($admin->updateGroup($arr, $id)) {

                        //$this->redirect('admin', 'admin_group_list');
						die();
                    } else {

                        $this->Viewer->assign('errmsg', '权限组更新出错!');
                    }
                }

            }
            foreach ($p as $k => $v) {
                if (isset($info[$k])) {
                    $info[$k] = $v;
                }
            }
        }

        $info['function'] = explode(',', $info['power']);
        $this->Viewer->assign('MenuGroup', $MenuGroup);

        $this->Viewer->assign('FunctionList', $FunctionList);
        $this->Viewer->assign('info', $info);

		$this->Viewer->assign('report_power',$report_power);
        $this->Viewer->display('admin/edit_admin_group.php');

    }


    function add_admin_group()
    {
		$FunctionList=Cfg::G('FunctionList');
		$MenuGroup=Cfg::G('MenuGroup');




		$tmp_group=$this->_db->fetchAll("select id,groupname,parent_id from menu_group");
		$layout=$this->_db->fetchAll("select * from report_layout");
		$tmp=array();
		if($tmp_group){
			foreach($tmp_group as $v){
				$tmp[$v['id']]=$v;
				$tmp[$v['id']]['sub_group']=array();
				$tmp[$v['id']]['menu']=array();
				foreach($layout as $l){
					if($l['rp_mark']==$v['id']){
						$tmp[$v['id']]['menu'][]=$l;
					}
				}
			}
		}

		$report_power=$tmp;
		$tmp=null;
		


        $p = _post();

        if (isset($p['saveedit']) && $p['saveedit'] == 1) {
            $admin = new admin();

            if ($p['name'] == '') {

                $this->Viewer->assign('errmsg', '请填写权限组名称');
            } elseif (!isset($p['power']) || !is_array($p['power']) || !count($p['power'])) {

                $this->Viewer->assign('errmsg', '请选择权限');
            } else {
                $getGroup = $admin->getGroupByName($p['name']);
                if ($getGroup) {

                    $this->Viewer->assign('errmsg', '该权限名称已存在,不能重复');
                } else {
                    $arr['name'] = $p['name'];
                    $arr['power'] = implode(',', $p['power']);
                    $arr['admin_id'] = $_SESSION['admin']['id'];
                    if ($admin->addGroup($arr)) {
                        $this->redirect('admin', 'admin_group_list');
                    } else {
                        $this->Viewer->assign('errmsg', '权限组添加出错!');
                    }
                }

            }
            foreach ($p as $k => $v) {
                $this->Viewer->assign($k, $v);
            }
            $this->Viewer->assign('power', isset($p['power']) ? $p['power'] : array());
        } else {
            $this->Viewer->assign('power', array());
        }

        //$info['function']=isset($p['power'])?$p['power']:array();
        $this->Viewer->assign('MenuGroup', $MenuGroup);
        $this->Viewer->assign('FunctionList', $FunctionList);
		
		$this->Viewer->assign('report_power',$report_power);

        $this->Viewer->display('admin/add_admin_group');
    }


//删除管理员帐号
    function delete_admin_group()
    {
        $id = intval(_request('id'));
        if (!$id) {
            $this->tips('请选择要删除的管理员组', 'index.php?controller=admin&method=admin_group_list');
        }
        $admin = new admin();
        $info = $admin->getGroupById($id);
        if (!$info) {
            $this->tips('要删除的管理员权限组不存在', 'index.php?controller=admin&method=admin_group_list');
        }
        $admin->del_admin_group($id);
        $this->tips('删除成功', 'index.php?controller=admin&method=admin_group_list');
    }


    function clear_cache()
    {

        deldir(WEB_CACHE_DIR);
        echo "<center>缓存已经清除</center>";
//

        /*  $p = _post();
          if ($p['clear'] || $p['clear'] == 1) {
              $dirs = $p['dirs'];
              if (!$dh = opendir(WEB_CACHE_DIR)) {
                  $this->tips('缓存目录读取错误!');
              }
              while ($f = readdir($dh)) {
                  if ($f == '.' || $f == '..') continue;
                  $path = WEB_CACHE_DIR . '/' . $f; //如果只要子目录名, path = $f;
                  if (is_dir($path)) {
                      if (in_array($f, $dirs)) {
                          deldir(WEB_CACHE_DIR);
                      }
                  }
              }
              $this->tips('清除缓存成功', 'index.php?controller=system&method=clear_cache');
          } else {
              $subdirs = array();
              if (!$dh = opendir(WEB_CACHE_DIR)) {
                  $this->tips('缓存目录读取错误!');
              }
              while ($f = readdir($dh)) {
                  if ($f == '.' || $f == '..') continue;
                  $path = WEB_CACHE_DIR . '/' . $f; //如果只要子目录名, path = $f;
                  if (is_dir($path)) {
                      $subdirs[] = $f;
                  }
              }
              $this->Viewer->assign('subdirs', $subdirs);
              $this->Viewer->display('admin/clear_cache.tpl');
          }*/
    }

}