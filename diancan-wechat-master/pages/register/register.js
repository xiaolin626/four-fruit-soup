// pages/login/index.js
import { isPhone } from '../utils/utils';
import { hexMD5 } from "../utils/md5";
import {
 Ruser
} from '../register/reginster-model';
import { Token } from '../utils/token';
var ruser = new Ruser;
var tokens=new Token;
var app = getApp();

Page({

  /**
   * 页面的初始数据
   */
  data: {
      role:'',
      user_input:"",
      password_input:"",
      rpassword_input:"",
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
rinputPwd:function(e){
  this.setData({
    rpassword_input: e.detail.value
  })
},


confirmPwd:function(){
  console.log(hexMD5('123456'))
  var usr = this.data.user_input;
  var pwd = this.data.password_input;
  var rpwd = this.data.rpassword_input;
  if(pwd==""||usr==""||rpwd==""){
      wx.showToast({
        title: '请输入账号和密码',
        icon: 'none',
        duration: 2000
      })
  }
  else if(isPhone(usr)==false)
  {
    wx.showToast({
      title: '输入非手机号',
      icon: 'none',
      duration: 2000
    })
  }
  else if(rpwd!=pwd)
  {
    wx.showToast({
      title: '两次输入密码不一致',
      icon: 'none',
      duration: 2000
    })
  }
  else{
    ruser.Reuser(usr,pwd);
  }
},
onLoad:function()
{
  
},

register:function()
{

},


})
