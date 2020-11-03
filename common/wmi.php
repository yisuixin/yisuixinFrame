<?php
namespace app\common;
class wmi {
    public $connection;
    public $error=array();
    public $objExecMethod;

    public function __construct($host = null, $Namespace='root\CIMV2', $username = null, $password = null,$charset=0) {
        if(!class_exists('COM')){
            exit('this extension requires php_com_dotnet.dllto be enabled!');
        }

        if(!$charset)
            $charset = CP_UTF8;
        if(!$username)
            $username = null;
        if(!$password)
            $username = null;
        if(!$host)
            $host = null;
        $wmiLocator = new COM('WbemScripting.SWbemLocator',null,$charset);
        try {
            $this->connection = $wmiLocator->ConnectServer($host, $Namespace, $username, $password);
            $this->connection->Security_->impersonationLevel = 3;
        } catch (Exception $e) {
            $this->connection = 0;
            $this->seterror($e);
        }
    }

    public function get_class_all(){
        if(!$this->connection)
            return array();
        $allquery = $this->connection->SubclassesOf();
        $retall = array();
        foreach ($allquery as $qualifier){
            $cls = $qualifier->Path_->Class;
            $retall[$cls] = array('class'=>$cls, 'Namespace'=>$qualifier->Path_->Namespace);
        }
        return $retall;
    }

    public function ExecMethod($mofpath=0,$func,$arp=array()){
        if($mofpath){
            $this->onceitem($mofpath);
        }
        try{
            if(is_object($this->objExecMethod) && property_exists($this->objExecMethod,$func)){
                return call_user_func_array(array($this->objExecMethod,$func),$arp);
            }else{
                throw new Exception('ExecMethod - is_object');
            }
        } catch (Exception $e) {
            $this->seterror($e);
        }
        return array();
    }

    public function setobjExecMethod($obj){
        $this->objExecMethod = $obj;
    }

    public function get_class_info($class=0){
        if(!$this->connection)
            return array();

        $allquery = $this->connection->InstancesOf($class);
        $ret = array();
        foreach ($allquery as $qualifier){
            $this->setobjExecMethod($qualifier);
            $allData = array();
            $allData['RelPath'] = $qualifier->Path_->RelPath;
            $allData['Server'] = $qualifier->Path_->Server;
            $allData['Namespace'] = $qualifier->Path_->Namespace;
            $allData['ParentNamespace'] = $qualifier->Path_->ParentNamespace;
            $allData['DisplayName'] = $qualifier->Path_->DisplayName;
            $allData['Class'] = $qualifier->Path_->Class;
            $allData['IsSingleton'] = $qualifier->Path_->IsSingleton;
            $allData['Locale'] = $qualifier->Path_->Locale;
            $allData['Authority'] = $qualifier->Path_->Authority;
            $allData['Qualifiers_Count'] = $qualifier->Qualifiers_->Count;
            $allData['Properties_Count'] = $qualifier->Properties_->Count;

            $allData['itemCount'] = $allquery->count;

            $Qualifiers_ = array();
            foreach ($qualifier->Qualifiers_ as $class){
                $Qualifiers_[$class->name] = $class->Value;
            }

            $allData['Qualifiers_'] = $Qualifiers_;

            $Properties_ = array();
            foreach ($qualifier->Properties_ as $class){
                $Properties_[] = $class->Name;
            }
            $allData['Properties_'] = $Properties_;

            $ret = $allData;
        }
        return $ret;
    }

    public function query($sql){
        if(!$this->connection)
            return array();
        try {
            $Dataobj = $this->connection->ExecQuery($sql); // ISWbemObjectSet
            $count = $Dataobj->count;
        } catch (Exception $e) {
            $this->seterror($e);
            $Dataobj = array();
        }
        return new Data_wmi($Dataobj);
    }

    public function once($sql){
        if(!$this->connection)
            return array();
        try {
            $Dataobj = $this->connection->ExecQuery($sql); // ISWbemObjectSet
            $count = $Dataobj->count;
            $Dataobj = new Data_wmi($Dataobj);
            $Dataobj = $Dataobj->fetch_array();
        } catch (Exception $e) {
            $this->seterror($e);
            $Dataobj = array();
        }
        return $Dataobj;
    }

    public function onceitem($mofpath){
        if(!$this->connection)
            return array();
        try {
            $tem = explode(':', $mofpath);
            $tem[1] = $tem[1]?$tem[1]:$tem[0];
            $tem = explode('=', $tem[1]);
            $tem = explode('.',$tem[0]);
            $clsname = $tem[0];
            $Dataobj = $this->connection->InstancesOf($clsname)->item($mofpath);   // ISWbemObjectEx
            $obj = new Data_wmi(0);
            $this->setobjExecMethod($Dataobj);
            $Dataobj = $obj->VARIANT_ArrAy($Dataobj);
        } catch (Exception $e) {
            $this->seterror($e);
            $Dataobj = array();
        }
        return $Dataobj;
    }

    public function seterror($e){
        $this->error['Message'] = $e->getMessage();
        $this->error['Code'] = $e->getCode();
        $this->error['file'] = $e->getFile();
        $this->error['fileLine'] = $e->getLine();
        $this->error['Trace'] = $e->getTrace();
        $this->error['Previous '] = $e->getPrevious();
    }
}

class Data_wmi{
    protected $obj;
    protected $count;
    protected $index;
    public function __construct($obj){
        $this->index = 0;
        if(!$obj)
            return $this;
        try{
            $this->obj = $obj;
            $this->count = $obj->Count;
        } catch (Exception $e) {
            $this->count = 0;
            $this->obj   = array();
        }
    }

    public function fetch_array(){
        if($this->count>0 && $this->count > $this->index){
            $ret = $this->obj->ItemIndex($this->index);
            $this->index++;
            return $this->VARIANT_ArrAy($ret);
        }
        return array();
    }

    public function VARIANT_ArrAy($process){
        $row = array();
        foreach($process->Properties_ AS $key => $val){
            if(is_object($val->value)){
                $tval = array();
                if(count($val->value)>0){
                    foreach($val->value AS $k => $v){
                        $tval[$k] = $v;
                    }
                    $kval =implode(',', $tval);
                }else{
                    $kval = null;
                }
                $kname = $val->name;
            }else{
                $kname = $val->name;
                $kval = $val->value;
            }
            $row[$kname] = $kval;
        }
        return $row;
    }
}

// 测试一下.
echo '<pre>';
$obj = new wmi();

// 一些错误判断, $this->error是最好的判断. 当然, 每个方法也会以返回为空来告诉你有错误.
$list = $obj->once('SELE4564CT * FROM Win32_Service'); //语法错误
$list = $obj->get_class_info('Win32_bios323232');            // class错误

// 调用命令.在精准读取方式后面调用, 可以直接沿用, $obj->ExecMethod(0,'StopService'); 省略第一个参数.
$ret = $obj->ExecMethod('Win32_Service.Name="Qampp_redis"','StopService');

// 取得当前空间所有的class
$list = $obj->get_class_all();
print_r($list);

// 取得某个class的详细信息.
$list = $obj->get_class_info('Win32_bios');
print_r($list);

// wsql查询后,循环读取.
$query = $obj->query('SELECT * FROM Win32_bios');
while($row = $query->fetch_array()){
    print_r($row);
}

// wsql查询后,只读一条.无顺序.
$list = $obj->once('SELECT * FROM Win32_Service'); //get once

// 精准读取一条.全路径匹配.
$list = $obj->onceitem('\\DESKTOP-C9G65RF\ROOT\CIMV2:Win32_Binary.Name="ISSELFREG.DLL",ProductCode="{B4C30EF4-B2C5-1395-B534-7B63BCB6E8E4}"'); // get once
print_r($list);

// 精准读取一条.
$list = $obj->onceitem('Win32_OperatingSystem=@'); // get once
print_r($list);

// 精准读取一条.
$list = $obj->onceitem('Win32_Service.Name="Fax"'); // get once
print_r($list);

// 沿用上一条onceitem的class, 来调用一个方法.
$ret = $obj->ExecMethod(0,'StopService');

// 精准读取一条
$list = $obj->onceitem('\\DESKTOP-C9G65RF\ROOT\CIMV2:Win32_Service.Name="Fax"'); // get once
print_r($list);

// 错误码.
print_r($obj->error);