<?php
/**
 *  常量定义文件
 *  @author: Gene
 */
// 常用正则匹配规则定义
define('REG_RULE_PHONE', '/^1[3,4,5,7,8][0-9]{9}$/');			// 手机号码
define('REG_RULE_EMAIL', '/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/');	// 电子邮箱
define('REG_RULE_URL', '/^((https|http):\/\/)[^\s]+$/');		// url地址
define('REG_RULE_NAME', '/^[a-zA-Z]\w{3,20}$/');// 用户名(只能包含字母、数字和下划线，且必须以字母开头)
define('REG_RULE_PASSWORD', '/^.{6,}/'); // 密码,六位以上




// 应用名称
define('APP_NAME', 'ghadmin');
