<?php
namespace app\modules\rabc\model;

use Yii;
use app\models\BaseModel;
use app\common\lib\Tree;
use app\common\lib\File;
use app\modules\rabc\model\Role;
use yii\db\Expression;


class Menu extends BaseModel{

    const MENU_TYPE1 = 1;const MENU_TYPE2 = 2;//菜单类型1页面2菜单；
    const MENU_LEVEL1 = 1;const MENU_LEVEL2 = 2;const MENU_LEVEL3 = 3;//菜单等级；1一级菜单，2二级菜单，3三级菜单
    const MENU_STATUS1 = 1;const MENU_STATUS2 = 2;//菜单状态；1显示2隐藏
    const CREATE_TAMPLATE_ONE = 1;const CREATE_TAMPLATE_TWO = 2;//是否生成前端模板，1是，2否


    //表名
    public static function tableName(){
        return "{{%menu}}";
    }
    public function scenarios(){
        $s = parent::scenarios();
        $s['add_menu']  = ['parent_id','title','name','type','status','icon','href','level','template','create_template'];//新增菜单规则
        $s['edit_menu']  = ['parent_id','title','name','type','status','icon','href','level','create_template'];//编辑菜单规则
        return $s;
    }
    //规则
    public function rules(){
        return [
            [['parent_id','title','type','status','level','href','template'], 'required', 'message' => '{attribute}不能为空','on'=>['add_menu','edit_menu']],
            [['name','e_name','type','status','level'], 'required', 'message' => '{attribute}不能为空','on'=>['add_menu_level1','add_menu_level2']],
            [['parent_id'], 'required', 'message' => '菜单上级不能为空','on'=>['add_menu_level2','edit_menu']],
            [['url'], 'required', 'message' => '菜单路由不能为空','on'=>['add_menu','edit_menu']],
        ];
    }
    public function attributeLabels(){
        return [
            'level'=>'菜单等级',
            'parent_id'=>'菜单父级',
            'title' => '菜单名称',
            'name' => '菜单别名',
            'e_name' => '菜单别名',
            'type' => '菜单类型',
            'status' => '菜单状态',
            'template'=>'vue模板文件'
        ];
    }
    /**
     * 获取全部菜单列表
     */
    public static function getListMenu(){
        $list = (new menu())->find()->orderBy('sort ASC')->with('pagePermissionList')->select('id,parent_id,title,type,icon,sort')->asArray()->all();
        $data = Tree::manyArray($list,$pid = 0,'parent_id','id');
        return $data;
    }
    /**设置菜单等级
     * @param int $level
     */
    public function setMenuLevel($level = 0){
        if($level == 0){
             $this->level = 1;
        }else{
            $this->level = $level + 1;
        }
    }
    /**
     * 添加完菜单之后生成前端vue文件模板
     * @param $insert
     * @param $changedAttributes
     */
    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        if($insert && $this->create_template == self::CREATE_TAMPLATE_ONE) {//如果选择生成前端vue模板才会生成
            $fileName = \Yii::$app->params['vue_template_cata'].'/'.$this->template.'.vue';
            $vueTempContent = '<template><div>This is '.$this->href.'</div></template>';
            if($this->parent_id != 0 ){
                $careteFile = (new File())->create_file($fileName);//创建前端vue文件
                $writeContent = (new File())->writeContent($fileName,$vueTempContent);//创建前端vue文件
            }
        } else {
            //这里是更新数据
        }
    }
    /**
     * 获取页面权限列表
     */
    public function getRolePagePermissionList(){
        $pagePermissionList = (new menu())->find()
            ->with('pagePermissionList')
            ->select('id,parent_id,title,type,icon')
            ->orderBy('sort ASC')
            ->where(['type'=>Menu::MENU_TYPE1])->asArray()->all();

        $allMenuList = (new menu())->find()
            ->select('id,parent_id,title,type,icon')
            ->orderBy('sort ASC')
            ->asArray()->all();
        foreach ($pagePermissionList as $k => $v){
            $all_parent_title =  Tree::getMenuColumns($allMenuList,$v['id'],'parent_id','id','title');
           $all_parent_id    =  Tree::getMenuColumns($allMenuList,$v['id'],'parent_id','id','id');

            $pagePermissionList[$k]['all_parent_title'] = implode(' / ',$all_parent_title);
           $pagePermissionList[$k]['all_parent_id']    =  $all_parent_id;
        }
        return $pagePermissionList;
    }
    public function getPagePermissionList(){
        return $this->hasMany(PagePermission::className(),['menuId'=>'id'])->asArray();
    }
    public function getRoleMenuList(){
        return $this->hasMany(RoleMenuItem::className(),['id'=>'menu_id'])->asArray();
    }

}