<?php
ini_set('display_errors', false);
/**
 * WEB_PATH
 *
 * 网站所在目录
 *
 * @constvar string WEB_PATH
 */
define('WEB_PATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

/**
  * G_DEBUG
  * 
  * 是否开启调试功能.调试功能将打印出所有错误信息
  *
  * @constvar bool G_DEBUG
 */
define("G_DEBUG",true);

/**
 * W_ROOT_PATH
 *
 * 网站程序所在目录
 *
 * @constvar String W_ROOT_PATH
 */
define('W_ROOT_PATH', WEB_PATH);

/**
 * W_MODEL_PATH
 *
 * 模块类存放目录
 *
 * @constvar String W_MODEL_PATH
 */
define('W_MODEL_PATH', WEB_PATH . 'Model' . DIRECTORY_SEPARATOR);

/**
 * W_CONTROLLER_PATH
 *
 * 控制器类所在目录
 *
 * @constvar String W_CONTROLLER_PATH
 */
define('W_CONTROLLER_PATH', WEB_PATH . 'Controller' . DIRECTORY_SEPARATOR);

/**
 * W_EXT_INCLUDE_PATH
 *
 * 其它你可能会用到的类库所在的目录,类库命名规则必须为"类名.class.php",如果你想框架自动加载.请在此添加,多个以";"分号隔开
 *
 * @constvar String W_EXT_INCLUDE_PATH
 */
define('W_EXT_INCLUDE_PATH', WEB_PATH . "Utils" . DIRECTORY_SEPARATOR);
/**
 * WEB_FILES_PATH
 *
 * 配置文件所在目录,指定后,配置会自动检查该目录下所有config.*.php的文件,并加载
 *
 * @constvar string G_EXT_PATH
 */
define('CFG_FILES_PATH', WEB_PATH . 'config' . DIRECTORY_SEPARATOR);

define('CONTROLLER_PARAM_NAME','controller');
define('METHOD_PARAM_NAME','method');
define('DEFAULT_CONTROLLER','index');
define('DEFAULT_METHOD','index');

function pagestr_array($count,$page,$pagecount){
	$allpage=ceil($count/$pagecount)?ceil($count/$pagecount):1;
	$page_i=9;
	$tmp_page=$page;
	$cut_count=4;
	if($page<4){
		$cut_count=$page;
	}
	$page_arr=array();
	for($i=1;$i<$cut_count;$i++){
		$page_arr[]=$page-$i;
		$page_i--;
	}
	$page_arr[]=$page;
	if($allpage<($page+$page_i)){
		$page_i=$allpage-$page;
	}

	for($i=1;$i<=$page_i;$i++){
		$page_arr[]=$page+$i;
	}
	sort($page_arr);
	return $page_arr;
}


//生成分页条
function pagestr($count,$page,$pagecount,$paramkey=array(),$otherpar=''){
	$allpage=ceil($count/$pagecount)?ceil($count/$pagecount):1;
	$page_i=9;
	$page_str="<div class='page'>".$count."条记录,共".$page."/".$allpage."页";
	$params='';
	if($paramkey){
		foreach($paramkey as $v){
			$params[$v]=_request($v)?_request($v):'';
		}
	}
	$paramstr=http_build_query($params);
	if($otherpar){
		$paramstr.="&".$otherpar;
	}


	$tmp="<span class='current'>".$page."</span>";
	$tmp_page=$page;
	$cut_count=4;
	if($page<4){
		$cut_count=$page;
	}
	for($i=1;$i<$cut_count;$i++){
		$tmp="<a href='index.php?page=".($page-$i)."&".$paramstr."'>".($page-$i)."</a>".$tmp;
		$page_i--;
	}
	if($allpage<($page+$page_i)){
		$page_i=$allpage-$page;
	}

	for($i=1;$i<=$page_i;$i++){
		$tmp.="<a href='index.php?page=".($page+$i)."&".$paramstr."'>".($page+$i)."</a>";
	}




	if($page==1){
		$page_str.="<span class='disabled'>第一页</span><span class='disabled'>上一页</span>";
	}else{
		$page_str.="<a href='index.php?page=1&".$paramstr."'>第一页</a><a href='index.php?page=".($page-1)."&".$paramstr."'>上一页</a>";
	}
	$page_str.=$tmp;
	if($page>=$allpage){
		$page_str.="<span class='disabled'>下一页</span><span class='disabled'>最末页</span>";
	}else{
		$page_str.="<a href='index.php?page=".($page+1)."&".$paramstr."'>下一页</a><a href='index.php?page=".$allpage."&".$paramstr."'>最末页</a>";
	}

	$page_str.="</div>";
	return $page_str;
	//<div class='page'><{$count}>条记录，共<{$page}>/<{$allpage}>页<span class='disabled'>第一页</span><span class='disabled'>上一页</span><span class='current'>1</span><span class='disabled'>下一页</span><span class='disabled'>最末页</span></div>


}


/**
 * 分页函数
 * 
 * @param int $count 总页数
 * @param int $page 当前页
 * @param int $pagecount 单页数据条数
 * @param array 需要从请求继承的参数key
 * @param $othrpar 其他的url参数字符串
 * @return string
 */
function pagestr2($count,$page,$pagecount,$paramkey=array(),$otherpar=''){
	$allpage=ceil($count/$pagecount)?ceil($count/$pagecount):1;
	$page_i=9;
	$page_str="<div class=\"pagenavi\"><ul><li><a href=\"#\">".$page."/".$allpage."</a></li>";
	$params='';
	if($paramkey){
		foreach($paramkey as $v){
			$params[$v]=_request($v)?_request($v):'';
		}
	}
	$paramstr=http_build_query($params);
	if($otherpar){
		$paramstr.="&".$otherpar;
	}


	$tmp="<li class=\"current\"><a href=\"#\" title=\"\">".$page."</li>";
	$tmp_page=$page;
	$cut_count=4;
	if($page<4){
		$cut_count=$page;
	}
	for($i=1;$i<$cut_count;$i++){
		$tmp="<li><a href='index.php?page=".($page-$i)."&".$paramstr."'>".($page-$i)."</a></li>".$tmp;
		$page_i--;
	}
	if($allpage<($page+$page_i)){
		$page_i=$allpage-$page;
	}

	for($i=1;$i<=$page_i;$i++){
		$tmp.="<li><a href='index.php?page=".($page+$i)."&".$paramstr."'>".($page+$i)."</a></li>";
	}




	if($page<=1){
		$page_str.="<li><a href=\"#\">第一页</a></li><li><a href=\"#\">上一页</a></li>";
	}else{
		$page_str.="<li><a href='index.php?page=1&".$paramstr."'>第一页</a></li><li><a href='index.php?page=".($page-1)."&".$paramstr."'>上一页</a></li>";
	}
	$page_str.=$tmp;
	if($page>=$allpage){
		$page_str.="<li><a href=\"#\">下一页</a></li><li><a href=\"#\">最后一页</a></li>";
	}else{
		$page_str.="<li><a href='index.php?page=".($page+1)."&".$paramstr."'>下一页</a></li><li><a href='index.php?page=".$allpage."&".$paramstr."'>最末页</a></li>";
	}

	$page_str.="</ul></div>";
	return $page_str;
	//<div class='page'><{$count}>条记录，共<{$page}>/<{$allpage}>页<span class='disabled'>第一页</span><span class='disabled'>上一页</span><span class='current'>1</span><span class='disabled'>下一页</span><span class='disabled'>最末页</span></div>



}


//删除文件目录
function deldir($dir) {
	//先删除目录下的文件：
	$dh=opendir($dir);
	while ($file=readdir($dh)) {
		if($file!="." && $file!="..") {
			$fullpath=$dir."/".$file;
			if(!is_dir($fullpath)) {
				unlink($fullpath);
			} else {
				deldir($fullpath);
			}
		}
	}

	closedir($dh);
	//删除当前文件夹：
	if(rmdir($dir)) {
		return true;
	} else {
		return false;
	}
}

//创建文件目录
function makedir($basedir,$dir){
	$dirs=explode("/", $dir);
	if(!$dirs){
		return true;
	}
	foreach($dirs as $v){
		if(!is_dir($basedir.'/'.$v) && !mkdir($basedir.'/'.$v,0777)){
			return false;
		}
		$basedir.='/'.$v;
	}
	return true;
}


function safestr($s){
	if(!get_magic_quotes_gpc()){
		$s=addslashes($s);
	}
	return $s;
}

require "./../../newframe/enter.php";
