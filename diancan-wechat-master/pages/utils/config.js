class Config{
  constructor(){}
}
//如果需要后端接口地址请联系 加V: 18850737047
// 400 bushi cuowu不是错误  程序没有异常把  就是一个灭有地址的返回 结果
// 程序异常会  或者找不到 404

Config.debug = false;
Config.restUrl = Config.debug ? 'http://linzer626.com/api/v1/' : "http://linzer626.com/api/v1/";
Config.picUrl = Config.debug ? 'http://linzer626.com/' : "https://api.coderyun.cn";

 
    
export {Config}; 