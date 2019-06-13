<?php
$data = '@小爱   ';

list(,$content) =  preg_split("/[\s]+/", $data);
var_dump($content);
exit();

/**
 * Class Order
 */
class Order
{
    use Meta;

    private $orderId = '001';

    private static $defaultMoney = '100';

    public $num = 1;
}

/**
 * Trait Meta
 */
trait Meta
{
    /**
     * 增加方法容器
     *
     * @var array
     */
    private $method = [];

    /**
     * 增加方法
     *
     * @param string $methodName
     * @param Closure $callBack
     * @throws Exception
     */
    public function addMethod($methodName, $callBack)
    {
        if (!is_callable($callBack)) {
            throw new Exception('该回调无法调用');
        }

        // 调用该方法
        $this->method[$methodName] = $callBack->bindTo($this, get_class());
        // 或者 $this->method[$methodName] = Closure::bind($callBack, $this,  get_class());
    }

    /**
     * 魔术方法调用
     * 
     * @param $methodName
     * @param array $args
     * @return mixed
     */
    public function __call($methodName, array $args)
    {
        if (isset($this->method[$methodName])) {
            return call_user_func_array($this->method[$methodName], $args);
        }
    }

}

// 客户端调用如下

$order = new Order();
$order->addMethod('getOrderId', function () {
    return "订单ID：{$this->orderId}";
});

echo $order->getOrderId();
exit();














$startMemory = memory_get_usage();
xdebug_debug_zval('startMemory');
$array = range(1, 100000);
$endMemory  = memory_get_usage();
var_dump($endMemory,$startMemory);
echo  $endMemory - $startMemory ;

exit();
echo date("Y-m-d H:i:s",1554883434);

var_dump( strtotime(' +5 day'));exit();

$c = '11111{$b}22222';
$a = [ 'b'=>'aaaaaaaaaaa','v'=>'4324234'];
extract($a);
@eval("\$s = \"$c\";");
print_r($a);
print_r($s);
exit();

$a     = '/a/b/c/d/e.php';
$b     = '/a/b/12/34/c.php';
function getRelativePath($fileA, $fileB) {

    $arrA = explode("/", $fileA); 
    $arrB = explode("/", $fileB); 
    array_pop($arrA);
    array_pop($arrB);

    $offset = 0;
    print_r($arrB);
    foreach($arrB as $key => $value) {
        if(!isset($arrA[$key]) || ($arrA[$key] != $arrB[$key])) {
            $offset = $key;
            var_dump($offset);
            break;
        }
    }

    $relativePath = '';

    for($i = $offset; $i <count($arrB); $i++) {
        $relativePath .= '../'; 
    }

    for($i=$offset; $i<count($arrA); $i++) { 
        $relativePath .= $arrA[$i].'/';
    }

    return $relativePath; 
}
echo getRelativePath($a,$b);
exit();

var_dump(ord('A'));exit();

function insertSort($arr) {
    //区分 哪部分是已经排序好的
    //哪部分是没有排序的
    //找到其中一个需要排序的元素
    //这个元素 就是从第二个元素开始，到最后一个元素都是这个需要排序的元素
    //利用循环就可以标志出来
    //i循环控制 每次需要插入的元素，一旦需要插入的元素控制好了，
    //间接已经将数组分成了2部分，下标小于当前的（左边的），是排序好的序列
    $len=count($arr);
    for ($i=1; $i < $len; $i++) {
        //获得当前需要比较的元素值。
        $tmp = $arr[$i];
        //内层循环控制 比较 并 插入
        for ($j = $i - 1; $j >= 0; $j--) {
            var_dump($j);
            //$arr[$i];//需要插入的元素; $arr[$j];//需要比较的元素
            if ($tmp < $arr[$j]) {
                //发现插入的元素要小，交换位置
                //将后边的元素与前面的元素互换
                $arr[$j + 1] = $arr[$j];
                //将前面的数设置为 当前需要交换的数
                $arr[$j] = $tmp;
            } else {
                //如果碰到不需要移动的元素
                //由于是已经排序好是数组，则前面的就不需要再次比较了。
                break;
            }
        }
        print_r($arr);
    }
    //将这个元素 插入到已经排序好的序列内。
    //返回
    return $arr;
}


$a = [9,3,23,4,45,26,57,18,29];

print_r(insertSort($a));
exit();


function choic($arr){
    $len = count($arr);
    for($k=0;$k<$len-1;$k++){
        $tmp = $k;
        for($j=$k+1;$j<$len;$j++){
            if($arr[$j] > $arr[$tmp]){
                $tmp = $j;
            }
        }
        list($arr[$k],$arr[$tmp]) = [$arr[$tmp],$arr[$k]];
    }
    return $arr;
}

print_r(choic($a));
exit();

foreach ($a as $key => $value) {
    echo 'a';
   if( next($a) === false){
        // var_dump($value);
   };
    print_r($value);
}

exit();


$c = '11111{$b}22222';
$a = [ 'b'=>'aaaaaaaaaaa','v'=>'4324234'];
extract($a);
eval("\$s = \"$c\";");

print_r($s);


var_dump($b);
exit();
var_dump(ord('a'));
exit();
$a = [4,5,4,7,4,43,7,8,4,7,9,3,5,66,3];
$b = '3232423423423';


function putFile($file){
    $handle = fopen($file,'w');
    if(flock($file,LOCK_EX)){
        fwrite($handle, '31232131');
        flock($file,LOCK_UN);
    }
    fclose($handle);
}


// function f2($arr ,$target){
//     $strat  = 0;
//     $end    = count($arr)-1;
//     while($start <  $end ){
//         $mid  = ceil(  ($start +$end)/2 );
// //         if( $arr[$mid] == $target ){
// //             return $mid;
// // 　　　　}
// 　　　　//查询的数小，往左继续查找
// 　　　　if( $arr[$mid] > $target){
// 　　　　　　$end = $mid - 1;
// 　　　　}

// 　　　　//查询的数大，往右继续查找
// 　　　　if($arr[$mid] < $target)
// 　　　　{
// 　　　　　　$start = $mid + 1;
// 　　　　} 

//     }
// }
print_r(f2($a,4));

exit();

function bb($a){
    $len = count($a);
    for($k=1;$k<$len;$k++){
        for($j=0;$j<$len-$k;$j++){
            if($a[$j] >$a[$j+1] ){
                list( $a[$j] , $a[$j+1] ) = [ $a[$j+1] ,$a[$j] ];
            }
        }
    }
    return $a;
}

function choice($a){
    $len = count($a);
    for($k=0;$k<$len-1;$k++){
        $tmp = $k;
        for($j=$k+1;$j<$len;$j++){
            if($a[$j] < $a[$tmp] ){
                $tmp = $j;
            }
        }
        list( $a[$k] , $a[$tmp] ) = [ $a[$tmp] ,$a[$k] ];
    }
    return $a;
}

function quick($a){
    if(count($a) <=1)return $a;
    $mid = $a[0];
    $right = $left = [];
    for($i=1;$i<count($a);$i++){
        if($a[$i] >$mid ){
            $right[] = $a[$i];
        }else{
            $left[]  = $a[$i];
        }
    }
    $left   = quick($left);
    $right  = quick($right);
    return array_merge($left,[$mid],$right);
}


$b = quick($a);
print_r($b);
exit();


$qpt = 'to live, but not live to eat'; 
echo preg_match("/^to/", $qpt); 
die();
function readF($file){
    $file = fopen($file,'a+');
    while(!feof($file) ){
        yield fgets($file);
    }
}
foreach (readF('server.php') as  $v) {
    print_r($v);
}
exit();
    $str = "private long contract_id;
    private string contract_number;
    private string customer_name;";

    $pattern = '/(_)(\w)+/';
    $result = preg_replace_callback($pattern,function($match){ print_r($match);},$str);
    echo $result;
exit();
class Re{
    public $a;
    public function set($data){
        $this->a  = $data;
    }
    public function get(){
        return $this->a;
    }
}
class Contain{
    public $re;
    public function __construct($re){
        $this->re = $re;
    }

    public function set($data){
        $this->re->set($data);
    }

}




$a  = new Re;
$c  = new Contain($a);
$d = $c;
$c->set('453453453453');
$d->set('111111111111');

print_r($c);
print_r($a);
var_dump($a->get());
exit();



trait util{
    public function use(){
        echo 'use'.PHP_EOL;
    }
}

class A{
    public static $in =1; 
}

class B extends A{
    // public static $in ;
}

$a = new A;
$b = new B;
echo A::$in;
A::$in += 1;
echo B::$in;
exit();


require __DIR__.'/vendor/autoload.php';
interface log
{
    public function write();   
}

// 文件记录日志
class FileLog implements Log
{
    public function __construct(){

    }

    public function write(){
        echo 'file log write...';
    }   
}

// 数据库记录日志
class DatabaseLog implements Log
{
    public function __construct(){

    }

    public function write(){
        echo 'database log write...';
    }   
}

class User 
{
    protected $log;

    public function __construct(FileLog $log)
    {
        $this->log = $log;   
    }

    public function login()
    {
        // 登录成功，记录登录日志
        echo 'login success...';
        $this->log->write();
    }

}

function make($concrete){
    //根据类名获取反射
    $reflector = new ReflectionClass($concrete);
    //获取构造方法
    $constructor = $reflector->getConstructor();
    // 为什么这样写的? 主要是递归。比如创建FileLog不需要传入参数。
    var_dump($constructor);
    if(is_null($constructor)) {
        return $reflector->newInstance();
    }else {
        // 构造函数依赖的参数
        $dependencies = $constructor->getParameters();
        var_dump($dependencies);
        // dd($dependencies);
        // 根据参数返回实例，如FileLog
        $instances = getDependencies($dependencies);
        // print_r($instances);
        //  依赖注入
        return $reflector->newInstanceArgs($instances);
    }

}

function getDependencies($paramters) {
    $dependencies = [];
    foreach ($paramters as $paramter) {
        $dependencies[] = make($paramter->getClass()->name);
    }
    return $dependencies;
}


function add(...$param){
    dd($param);
}

add(...[1,2,3]);

$user = make('User');
$user->login();