<?php

/**
 * ECSHOP ajax
 * ============================================================================
 * 版权所有 2005-2016 热风科技，并保留所有权利。
 * 演示地址: http://palenggege.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: www.68ecshop.com $
 * $Id: ajax.php 17063 2010-03-25 06:35:46Z $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ($_REQUEST['act'] == 'tipemail')
{
	require(ROOT_PATH . 'includes/cls_json.php');
	$word_www_68ecshop_com = json_str_iconv($_REQUEST['word']);
	$json_www_68ecshop_com   = new JSON;
	$result_www_68ecshop_com = array('error' => 0, 'message' => '', 'content' => '');
	
	if(!$word_www_68ecshop_com ||  strlen($word_www_68ecshop_com) > 30)
	{
        $result_www_68ecshop_com['error']   = 1;
		die($json_www_68ecshop_com->encode($result_www_68ecshop_com));
	}
	$word_www_68ecshop_com = str_replace(array(' ','*', "\'"), array('', '', ''), $word_www_68ecshop_com);

	$email_name_arr = explode("@", $word_www_68ecshop_com);
	$email_name = $email_name_arr[0];
    
	$_CFG['email_domain'] =str_replace(" ", "",$_CFG['email_domain']);
	$email_domain_arr = explode(",", str_replace("，",",",$_CFG['email_domain']));

    $logdb=array();
	foreach($email_domain_arr AS $key=>$edomain)
	{
		$email_domain_arr[$key] = $email_name.'@'.$edomain;
	}

	foreach($email_domain_arr AS $email_domain)
    {
		if (stristr($email_domain, $word_www_68ecshop_com))
		{
			$logdb[] = $email_domain;
		}
	}
	$smarty->assign('logdb', $logdb);	

	if(count($logdb)==0)
	{
		$result_www_68ecshop_com['content'] = '';
	}
	else
	{		
		$result_www_68ecshop_com['content'] = $smarty->fetch('library/email_tip.lbi');
	}
	

	die($json_www_68ecshop_com->encode($result_www_68ecshop_com));
}
?>