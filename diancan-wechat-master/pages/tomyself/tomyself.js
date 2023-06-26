import { isPhone } from '../utils/utils';
import {
  Base
} from '../utils/base.js';
import {
  My
} from '../my/my-model.js';
const app = getApp();
var BaseObj = new Base();
var my = new My();
var utils=require('../utils/utils');
Page({

  /**
   * 页面的初始数据
   */
  data: {
    uid:'',
    money:0,
    sex: 0,
    columns: ['女', '男'],
    show: false,
    home_address:'',
    work_address:'',
    nickName: '',
    password:'',
    mobile:'',

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function(options) {
    this.foruserdata();
  },
  showPopup() {
    this.setData({
      show: true
    });
  },
  //获取用户信息

  homeaddress()
  {
    app.globalData.flag=3,
    navigateTo('../selectaddress/selectaddress')
  },
  toCash()
  {
    console.log("前往提现页面")
    wx.navigateTo({
      url: '../toCash/toCash?mobile='+this.data.mobile+'&money='+this.data.money+'&id='+this.data.uid,
    })
  },
  foruserdata:function()
  {
  
   this.setData({
         usr: app.globalData.username,
   })

 console.log(this.data.usr)
  var dsr=this.data.usr;
  
 if(dsr==''||dsr==123)
 {
  
   console.log("进入方法一")
   this.getusertoken((res) => {
     this.setData({
       mobile:res.mobile,
       sex:res.sex,
       nickName:res.nickname,
       uid:res.id,
       money:res.money
      });
   })
 }
 else{
   my.getuser(dsr, (res) => {
   console.log(res.nickname)
     this.setData({
       mobile:res.mobile,
       sex:res.sex,
       nickName:res.nickname,
       uid:res.id,
      money:res.money
    });
 })
 }
 
 
 },
 getusertoken(Callback) {
  var dparams = {
    url: 'User/by_token',
    type: 'get',
    sCallback: function(res) {
      Callback && Callback(res);
    }
  }
  BaseObj.request(dparams); 

},
  onClose() {
    this.setData({
      show: false
    });
  },
  toIssue()
  {
  if(isPhone(this.data.mobile)==false)
  {
    wx.showToast({
      title: '输入非手机号',
      icon: 'none',
      duration: 2000
  })
}
else if(this.data.password.length<6)
{
  wx.showToast({
    title: '密码设置过短，请重新输入',
    icon: 'none',
    duration: 2000
})
}
else if(this.data.nickName=='')
{
  wx.showToast({
    title: '昵称不为空',
    icon: 'none',
    duration: 2000
})
}
else if(this.checkRate(this.data.password)==false)
{
 
  wx.showToast({
    title: '密码应设置数字与字母',
    icon: 'none',
    duration: 2000
})
}
  else
  {
    var params = {
      url: 'User/edit_user',
      type:'post',
      data:{
      nickname:this.data.nickName,
      password:this.data.password,
      sex:this.data.sex,
      mobile:this.data.mobile
      },
      sCallback: function(res) {
        wx.showToast({
          title: '修改成功',
          icon: 'none',
          duration: 2000
      })

      },
    eCallback:function(res) {
      wx.showToast({
        title: '修改不能为空，请确认  ',
        icon: 'none',
        duration: 2000
    })
    }}
    BaseObj.request(params);
    
   }
  },
  changehead()
  { wx.chooseImage({
    count: 1, // 默认9
    sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有
    sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
    success(res) {
      const src = res.tempFilePaths[0]
      var url= '../cutoutHeads/cutoutHeads?src=' + src
      navigateTo(url)
      
    }
  })
     
  },
  //判断字符串是否为数字和字母的组合

checkRate(nubmer)
{
  
     var re = new RegExp('(?=.*[0-9])(?=.*[a-zA-Z]).{6,10}');
          //密码中必须包含字母（不区分大小写）、数字，至少6个字符，最多10个字符；
     if (!re.test(nubmer))
    {
      
        return false;
     }else{
    return true;
     }
},
  onConfirm(event) {
    const {
      value,
      index
    } = event.detail;
    this.setData({
      sex: index,
      show: false
    })
  },
  
  nickNameChange(e) {
    // event.detail 为当前输入的值
    var nickname = e.detail.value;
    this.setData({
      nickName: nickname
    })
    console.log(e.detail);
  },
  psdChange(e) {
    // event.detail 为当前输入的值
    var psd = e.detail.value;
    this.setData({
      password: psd
    })
    console.log(e.detail);
  },
  mobileChange(e) {
    // event.detail 为当前输入的值
    var mob = e.detail.value;
    this.setData({
      mobile: mob
    })
    console.log(e.detail);
  },
  onChange(event) {
    const {
      picker,
      value,
      index
    } = event.detail;
    // Toast(`当前值：${value}, 当前索引：${index}`);
  },


  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function() {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function() {
  
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function() {

  },




  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function() {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function() {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function() {

  }
})