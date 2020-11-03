<?php
/**
 * name:无限级类
 * time:16-11-22
 * by:xiaoming
 */

namespace app\common\lib;
use app\modules\rabc\model\Menu;
class Tree{
	/*
	select无限极分类
	$data数组
	$pid父级id
	*/
	static function infinite($data,$parent_name,$id,$pid = 0,$html = '└─&nbsp',$level = 0){
	
	  $str = '';
	  if($level != 0){
	    for($i = 0;$i<$level;$i++){
	      $str .= '&nbsp&nbsp&nbsp&nbsp';  
	    }
	      $str  = $str.$html;
	  }
	  $arr = array();
	  foreach ($data as $k => $v) {
	      if($v[$parent_name] == $pid){
	        $v['html']  = $str;
	        $arr[] = $v;
	        $arr   = array_merge($arr,self::infinite($data,$parent_name,$id,$v[$id],$html,$level + 1));
	      }
	  }
	  return $arr;
	}
    /**
    菜单组合树形
     */
    static function listTree($data,$pid = 0,$lev = 0,$parent_name,$id_name){
        $arr = array();
        foreach ($data as $k => $v) {
            if($v[$parent_name] == $pid){
                if($v['level'] == Menu::MENU_LEVEL1){
                    $v['html_name'] = '<span style="" class="html-name">'.$v['title'].'</span>';
                }elseif($v['level'] == Menu::MENU_LEVEL2){
                    $v['html_name'] = '<span style="margin-left:'.($v['level'] * 10).'px;" class="html-name">├─&nbsp;&nbsp'.$v['title'].'</span>';
                }else{
                    $v['html_name'] = '<span style="margin-left:'.($v['level'] * 10).'px;" class="html-name">&nbsp;&nbsp├─├─&nbsp&nbsp;'.$v['title'].'</span>';
                }
                $arr[]     = $v;
                $arr = array_merge($arr,self::listTree($data,$v[$id_name],$lev + 1,$parent_name,$id_name));
            }
        }
        return $arr;
    }
	//基本树形
	static function basicTree($cate,$html = '--',$pid,$level=0){
		$arr = array();
		foreach ($cate as $key => $v) {
			if($v['parentid'] == $pid){
				$v['level'] = $level+1;
				$v['html']  = str_repeat($html, $level);
				$arr[] = $v;
				$arr = array_merge($arr,self::basicTree($cate,$html,$v['t_id'],$level+1));
			}
		}
		return $arr;
	}
	//组合多维数组
	static function manyArray($cate,$pid = 0,$parent_name,$id_name){
		$arr = array();
		foreach ($cate as $key => $v) {
            $v['expand'] = true;
			if($v[$parent_name] == $pid){
                $v['label'] = $v['title'];
                $v['pagePermission'] = unserialize($v['pagePermission']);
				$v['children'] = self::manyArray($cate,$v[$id_name],$parent_name,$id_name);
				$arr[] = $v;
			}
		}
		return $arr;
	}
	//所有父级
	static function getAllParent($cate,$cid,$parent_name,$id_name){
		$arr = array();
		foreach ($cate as $key => $v) {
			if($v[$id_name] == $cid){
				$arr[] = $v;
				$arr = array_merge(self::getAllParent($cate,$v[$parent_name],$parent_name,$id_name),$arr);
			}
		}
		return $arr;
	}
	//父级所有子级id,不包括子级的子级
	static function getAllChilds($cate,$pid,$parent_name,$id){
		$arr = array();
		foreach ($cate as $key => $v) {
			if($v[$parent_name] == $pid){
				$arr[] = $v[$id];//$v全部，查找所有子级
				$arr   = array_merge($arr,self::getAllChilds($cate,$v[$id],$parent_name,$id));
			}
		}
		return $arr;
	}
	//父级所有子级id,包括子级的子级
	static function getMenuTree($arrCat, $pId = 0, $level = 0,$parent_id,$id){
	    static  $arrTree = array();
	    if(empty($arrCat)) return '';
	    foreach($arrCat as $key => $value){
	        if($value[$parent_id] == $pId){
	            $value[ 'level'] = $level;
	            $arrTree[] = $value[$id];
	            unset($arrCat[$key]); //注销当前节点数据，减少已无用的遍历
	            self::getMenuTree($arrCat, $value[$id], $level,$parent_id,$id);
	        }
	    }
	    return $arrTree;
	}
    //获取树形菜单中的某一个字段
    static function getMenuColumns($cate,$pid,$parent_name,$id,$columns){
        $arr = [];
        foreach ($cate as $key => $v) {
            if($v[$id] == $pid){
                $arr[] = $v[$columns];
                $arr = array_merge(self::getMenuColumns($cate,$v[$parent_name],$parent_name,$id,$columns),$arr);
            }
        }
        return $arr;
    }






}