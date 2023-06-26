import {
  Base
} from '../utils/base.js';

var BaseObj = new Base();

class Ruser extends Base{
  constructor() {
    
    super();
  }
 
   //获得用户信息
   Reuser(usr,password,callback) {
    var that = this;
    wx.login({
      //登陆获取code码
      success: function(res) {
        console.log(res);
        console.log(res.code);
        let code=res.code
        //访问服务器API
        wx.request({
          url: `https://api.weixin.qq.com/sns/jscode2session?appid=wx2b9672247683ed70&secret=dfd3020fabf0e1e9b64b02d34897be10&js_code=${code}&grant_type=authorization_code`,   
          success: function(res) {  
          var params = {
            url: 'User/create_user/'+usr+'/'+password+'/'+res.data.openid,
            method: 'get',
            sCallback: function(res) {
              wx.showToast({
                title: '注册成功',
              })
              setTimeout(function () {
                //要延时执行的代码
                  wx.navigateTo({
                    url: '../topass/topass',
                 })
              }, 1500) //延迟时间
            },
            eCallback:function(res) {
              console.log(res);
             if(res.error_code==70001)
             {
                wx.showToast({
                title: '用户已存在',
                icon: 'error',
              })
            }
              else if(res.error_code==90001)
              {
                wx.showToast({
                  title: '您已注册过账号',
                  icon: 'error',
              })
            }
             
             
      }   
      }
      BaseObj.request(params);
      }
          
          })
        
      }
    })
    
  }


}

export {Ruser};