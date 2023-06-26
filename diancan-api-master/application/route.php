<?php
/**
 * 路由注册
 *
 * 以下代码为了尽量简单，没有使用路由分组
 * 实际上，使用路由分组可以简化定义
 * 并在一定程度上提高路由匹配的效率
 */

// 写完代码后对着路由表看，能否不看注释就知道这个接口的意义
use think\Route;

//Sample
Route::get('api/:version/sample/:key', 'api/:version.Sample/getSample');
Route::post('api/:version/sample/test3', 'api/:version.Sample/test3');

//Miss 404
//Miss 路由开启后，默认的普通模式也将无法访问
//Route::miss('api/v1.Miss/miss');

//Banner
Route::get('api/:version/banner', 'api/:version.Banner/getBanner');

//Theme
// 如果要使用分组路由，建议使用闭包的方式，数组的方式不允许有同名的key
//Route::group('api/:version/theme',[
//    '' => ['api/:version.Theme/getThemes'],
//    ':t_id/product/:p_id' => ['api/:version.Theme/addThemeProduct'],
//    ':t_id/product/:p_id' => ['api/:version.Theme/addThemeProduct']
//]);

Route::group('api/:version/theme',function(){
    Route::get('', 'api/:version.Theme/getSimpleList');
    Route::get('/:id', 'api/:version.Theme/getComplexOne');
    Route::post(':t_id/product/:p_id', 'api/:version.Theme/addThemeProduct');
    Route::delete(':t_id/product/:p_id', 'api/:version.Theme/deleteThemeProduct');
});

//Route::get('api/:version/theme', 'api/:version.Theme/getThemes');
//Route::post('api/:version/theme/:t_id/product/:p_id', 'api/:version.Theme/addThemeProduct');
//Route::delete('api/:version/theme/:t_id/product/:p_id', 'api/:version.Theme/deleteThemeProduct');


//img
Route::post('api/:version/img/postimg', 'api/:version.Img/uploadimg');
Route::post('api/:version/img/again', 'api/:version.Img/askagain');
Route::post('api/:version/img/qsubmit', 'api/:version.Img/dispatcheruploadsubmit');
Route::post('api/:version/img/bsubmit', 'api/:version.Img/boosuploadsubmit');
//User
Route::get('api/:version/user/:id', 'api/:version.Userinfo/getUserinfo',[], ['id'=>'\d+']);
Route::get('api/:version/user/get_phone', 'api/:version.Userinfo/getUserphone');
Route::get('api/:version/user/by_token', 'api/:version.Userinfo/getUserinfotoken');
Route::post('api/:version/user/edit_user', 'api/:version.Userinfo/editUserinfo');
Route::get('api/:version/user/create_user/:usr/:password/:openid', 'api/:version.Userinfo/createUser',[],[]);

//Cash
Route::post('api/:version/cashs/money', 'api/:version.Cash/moneyApply');

//file
Route::post('api/:version/img/uptxt', 'api/:version.Img/uploadtxt');

//Product
Route::post('api/:version/product/b_pro', 'api/:version.Product/createpro');
Route::post('api/:version/product', 'api/:version.Product/createOne');
Route::delete('api/:version/product/:id', 'api/:version.Product/deleteOne');
Route::get('api/:version/product/by_category/paginate', 'api/:version.Product/getByCategory');
Route::get('api/:version/product/by_category', 'api/:version.Product/getAllInCategory');

Route::get('api/:version/product/:id', 'api/:version.Product/getOne',[],['id'=>'\d+']);
Route::get('api/:version/product/recent', 'api/:version.Product/getRecent');
Route::get('api/:version/product/recommend', 'api/:version.Product/getRecommend');
Route::get('api/:version/product/getd', 'api/:version.Product/getdproduct');

//Category
Route::get('api/:version/category', 'api/:version.Category/getCategories'); 
// 正则匹配区别id和all，注意d后面的+号，没有+号将只能匹配个位数
//Route::get('api/:version/category/:id', 'api/:version.Category/getCategory',[], ['id'=>'\d+']);
//Route::get('api/:version/category/:id/products', 'api/:version.Category/getCategory',[], ['id'=>'\d+']);
Route::get('api/:version/category/all', 'api/:version.Category/getAllCategories');
Route::get('api/:version/category/dall', 'api/:version.Category/getdAllCategories');
Route::get('api/:version/getSystem', 'api/:version.Category/getSystemInfo');

//Token
Route::post('api/:version/token/user', 'api/:version.Token/getToken');

Route::post('api/:version/token/app', 'api/:version.Token/getAppToken');
Route::post('api/:version/token/verify', 'api/:version.Token/verifyToken');

//Address
Route::post('api/:version/address', 'api/:version.Address/createOrUpdateAddress');
Route::get('api/:version/address', 'api/:version.Address/getUserAddress');
Route::post('api/:version/delAddress', 'api/:version.Address/delUserAddress');

//Order
Route::post('api/:version/order', 'api/:version.Order/placeOrder');
Route::get('api/:version/order/cancel', 'api/:version.Order/cancelor');
Route::get('api/:version/order/:id', 'api/:version.Order/getDetail',[], ['id'=>'\d+']);

Route::get('api/:version/order/changeorder5', 'api/:version.Order/changeOrder5');
Route::get('api/:version/order/changeorder6', 'api/:version.Order/changeOrder6');
Route::get('api/:version/order/changeorder7', 'api/:version.Order/changeOrder7');
Route::get('api/:version/order/checkOrderstute', 'api/:version.Order/checkOrderstute');
Route::get('api/:version/order/changeorderu', 'api/:version.Order/changeOrderu');
Route::get('api/:version/order/changeorderQuit', 'api/:version.Order/changeOrderQuit');

Route::put('api/:version/order/delivery', 'api/:version.Order/delivery');

//不想把所有查询都写在一起，所以增加by_user，很好的REST与RESTFul的区别
Route::get('api/:version/order/by_user', 'api/:version.Order/getSummaryByUser');

Route::get('api/:version/order/boss', 'api/:version.Order/getSummaryBoss');
Route::get('api/:version/order/q', 'api/:version.Order/getSummaryDispatcher');
Route::get('api/:version/order/paginate', 'api/:version.Order/getSummary');

//Pay
Route::post('api/:version/pay/pre_order', 'api/:version.Pay/getPreOrder');

Route::post('api/:version/pay/notify', 'api/:version.Pay/receiveNotify');
Route::post('api/:version/pay/re_notify', 'api/:version.Pay/redirectNotify');
Route::post('api/:version/pay/concurrency', 'api/:version.Pay/notifyConcurrency');

//Message
Route::post('api/:version/message/delivery', 'api/:version.Message/sendDeliveryMsg');



//return [
//        ':version/banner/[:location]' => 'api/:version.Banner/getBanner'
//];

//Route::miss(function () {
//    return [
//        'msg' => 'your required resource are not found',
//        'error_code' => 10001
//    ];
//});



//git 自动拉取
Route::post('api/:version/git_pull','api/:version.Git/gitPull');



