// pages/login/index.js
import { hexMD5 } from "../utils/md5";
import {
 User
} from '../topass/user-model.js';
var user = new User;

var app = getApp();

Page({

  /**
   * 页面的初始数据
   */
  data: {
     // 是否显示密码
     show_pass:false,
    inputType:"password",
   
      role:'',
      user_input:"",
      password_input:"",
      usr:"",
      key:"",
      nickname:"",
  },
  
    inputUsr:function(e){
  this.setData({
      user_input: e.detail.value
    })
},
inputPwd:function(e){
  this.setData({
    password_input: e.detail.value
  })
},

confirmPwd:function(){
  console.log(hexMD5('123456'))
  var usr = this.data.user_input;
  var pwd = this.data.password_input;
  
  user.getuser(usr, (res) => {
    this.setData({
      usr: res.mobile,
      key: res.password,
      role:res.role,
      nickname:res.nickname
     });
  })
  if(pwd==""||usr==""){
      wx.showToast({
        title: '请输入账号和密码',
        icon: 'none',
        duration: 2000
      })
  }
  else if(hexMD5(pwd) != this.data.key||usr != this.data.usr){
    wx.showToast({
      title: '账号或密码错误',
      icon: 'none',
      duration: 2000
    })
  }else{
    wx.showToast({
      title: '验证通过',
      icon: 'success',
      duration: 2000
    })
   app.globalData.username=this.data.usr;
    wx.switchTab({ //跳转到 tabBar 页面，并关闭其他所有非 tabBar 页面 就是首页  
      //用户授权成功后就要跳转到首页导航栏
      url: "/pages/food/food",
    });
  }
},

register:function()
{
  wx.navigateTo({
    url: '../register/register',
 })
},

seeTap:function(){
  var that=this;
  var newType = this.data.inputType=='password'?'text':'password';
  that.setData({
    // 切换图标
    show_pass:!that.data.show_pass,
    // 切换表单type属性
    inputType:newType,
  })
},


})
