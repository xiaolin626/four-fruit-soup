// pages/tojoin/tojoin.js
import {
  My
} from '../my/my-model.js';
import {
  Base
} from '../utils/base.js';
import { isPhone } from '../utils/utils';
import {
  Order
} from '../order/order-model.js';

var my = new My();
const app = getApp();
var order = new Order();
var BaseObj = new Base();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    
    orderType:2,

    steps: [
      {
        text: '未接单',
        inactiveIcon: 'location-o',
        activeIcon: 'success',
      },
      {
        text: '已接单',
        inactiveIcon: 'like-o',
        activeIcon: 'plus',
      },
      {
        text: '派送中',
        inactiveIcon: 'star-o',
        activeIcon: 'cross',
      },
      {
        text: '已完成',
        inactiveIcon: 'phone-o',
        activeIcon: 'fail',
      },
    ],

    buttonTrue:0,
    //订单列表数据
    orderArr: [],
    qorderArr: [],
    pageIndex:1,
     status:0,
  
     etest:0,
    astatus:0,
   
    ustatus:'',
    usr:"",
    userid:"",
    role:"123",
    nickname:"456",
    nickName:"",
    nickphone:"",
    imgsrc:[],
    imgid:[],
    img1:'',
    img2:'',
    img3:'',

    new_img1:'',
    new_img2:'',
    new_img3:'',
    imgflag:0,

    workImg:'',
    idfronttag:0,
    idbacktag:0,
    blicence:0,


    callphone:0,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad(options) {
  console.log("进入审核系统")
this._loadData();
if (wx.getStorageSync('role') ==0) {
  // 修改navigationBarTitleText
  wx.setNavigationBarTitle({
      title:'加入我们'
  })
}else if(wx.getStorageSync('role')==1)
{
wx.setNavigationBarTitle({
  title:'店长订单界面'
})
}
else if(wx.getStorageSync('role')==2)
{
wx.setNavigationBarTitle({
  title:'骑手订单界面'
})
}
  },
  selectIdfront()
  {
    var _this=this
    wx.chooseImage({
      count: 1, // 默认9
      sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有
      sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
      success(res) {
 
         _this.setData({
           'imgsrc[0]': res.tempFilePaths[0],
            img1:res.tempFilePaths[0],
            idfronttag:1
         })
         console.log(_this.data.imgsrc)
      }
    })
  },
  changebutton(event)
  {
    console.log(event)
    var id = order.getDataSet(event, 'id');
    
    var status =event.currentTarget.dataset.status;
    console.log(status)
    var that=this;

    if(status==2)
    {
      that.setData({
        orderType:0,
      })
    }else if(status==5)
    {
      that.setData({
        orderType:1,
      })
    }
    else if(status==6)
    {
      that.setData({
        orderType:2,
      })
    }
    else if(status==7)
    {
      that.setData({
        orderType:3,
      })
    }

    if(that.data.buttonTrue==id)
    {
      that.setData({
        buttonTrue:0,
       
      })
    }else
    {
      that.setData({
       buttonTrue:id,

     })
    }
  },
  toCallPhone(event)
  {
    var that=this;
    var buser_id = event.currentTarget.dataset.id;
    var params = {
      url: 'user/get_phone',
      method: 'GET',
      data: {
      callphone:buser_id
      },
      sCallback: function(res) {
     that.setData({
       callphone:res
     })
      }
    }
    BaseObj.request(params);
     wx.makePhoneCall({
        phoneNumber:this.data.callphone+"",
      })
  },
  selectIdback()
  {
    var _this=this
    wx.chooseImage({
      count: 1, // 默认9
      sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有
      sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
      success(res) {

         _this.setData({
           'imgsrc[1]': res.tempFilePaths[0],
           img2:res.tempFilePaths[0],
           idbacktag:1
         })
         console.log(_this.data.imgsrc)
      }
    })
  },
  selectBslicence()
  {
    var _this=this
    wx.chooseImage({
      count: 1, // 默认9
      sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有
      sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
      success(res) {

         _this.setData({
           'imgsrc[2]': res.tempFilePaths[0],
           img3:res.tempFilePaths[0],
           blicence:1
         })
         console.log(_this.data.imgsrc)
      }
    })
  },
  Dispatchersubmit()
  {
    var imgflag=this.data.imgflag;
    if(isPhone(this.data.nickphone)==false||this.data.nickName==''||this.data.nickphone==''||this.data.imgsrc.length!=2)
    {
      wx.showToast({
        title: '信息填写不完整',
      })
    }
    //后端判断用户信息是否合法
    //上传的照片是否合法
    //是否勾选服务条款
    else{
    var baseU='http://linzer626.com/uploads/weixin/'
    var _this=this
    for (var i = 0; i < this.data.imgsrc.length; i++) {
      console.log(i)
    console.log(_this.data.imgsrc[i]);
    wx.uploadFile({
      url: 'http://linzer626.com/api/v1/img/postimg', // 仅为示例，非真实的接口地址
      filePath: _this.data.imgsrc[i],
      formData: {
        user: 'test'
      },
      name: 'images',
      header: {
        "content-type": "multipart/form-data"
    },
    success:(res)=> {  
      var edata =JSON.parse(res.data);
      console.log(edata);

       var acp=edata.file;

     
      console.log(acp);
     
      console.log(i);
      var that=this;
      if(i==2)
      {
        console.log("填入一")
        that.setData ({
        new_img1:baseU+acp,})
        i++;
      }
      else if(i==3)
      {
        console.log("填入二")
        that.setData ({
          new_img2:baseU+acp,
         },() => {
        
          var params = {
           url: 'img/qsubmit',
           type:'post',
           data:{
             user_id:this.data.userid,
             name:this.data.nickName,
             idfront:this.data.new_img1,
             idback:this.data.new_img2,
             phone:this.data.nickphone,
             },
           sCallback: function (res) {
       
             wx.showToast({
               title: '修改成功',
               icon: 'none',
               duration: 2000
           })
           
           }
         }
         BaseObj.request(params);
         })
      }
      
     if (res.statusCode == 200) {
     wx.showToast({
       title: "上传成功",
       icon: "none",
     duration: 1500
       })
 }
    },
    fail: function (err) {
                            wx.showToast({
                                title: "上传失败",
                                icon: "none",
                                duration: 2000
                            })
                        },
    });         
    }
  
   }
    this.foruserdata();
     //跳转到成功页面
     
     setTimeout(function () {
      this.onLoad()
      //要延时执行的代码
       wx.switchTab({
         url: '../tojoin/tojoin',
       })
    }, 1500) //延迟时间
  },
  gogeren()
    {

      
      console.log("我的");
      wx.switchTab({
        url: '../my/my',
      })
    },
    askagain()
    {
      var params = {
        url: 'img/again',
        type:'post',
        data:{
          user_id:this.data.userid,
          },
        sCallback: function (res) {
    
          wx.showToast({
            title: '修改成功',
            icon: 'none',
            duration: 2000
        })
        
        }
      }
      BaseObj.request(params);

      this.onLoad()

      setTimeout(function () {
        //要延时执行的代码
         wx.switchTab({
           url: '../tojoin/tojoin',
         })
      }, 1500) //延迟时间





    },
 Bossubmit()
  {
    if(isPhone(this.data.nickphone)==false||this.data.nickName==''||this.data.nickphone==''||this.data.imgsrc.length!=3)
    {
      wx.showToast({
        title: '信息填写不完整或不正确',
      })
    }
    //后端判断用户信息是否合法
    //上传的照片是否合法
    //是否勾选服务条款
    else{
      var baseU='http://linzer626.com/uploads/weixin/'
      var _this=this
      for (var i = 0; i < this.data.imgsrc.length; i++) {
        console.log(i)
      console.log(_this.data.imgsrc[i]);
      wx.uploadFile({
        url: 'http://linzer626.com/api/v1/img/postimg', // 仅为示例，非真实的接口地址
        filePath: _this.data.imgsrc[i],
        formData: {
          user: 'test'
        },
        name: 'images',
        header: {
          "content-type": "multipart/form-data"
      },
      success:(res)=> {  
        var edata =JSON.parse(res.data);
        console.log(edata);
        var acp=edata["file"];
        console.log(i);
        var that=this;
        if(i==3)
        {
          console.log("填入一")
          that.setData ({
          new_img1:baseU+acp,})
          i++;
        }
        else if(i==4)
        {
          console.log("填入二")
          that.setData ({
            new_img2:baseU+acp,
           })
           i++;
        }
        else if(i==5)
        {
          console.log("填入三")
          that.setData ({
            new_img3:baseU+acp,
           },() => {
          
            var params = {
             url: 'img/bsubmit',
             type:'post',
             data:{
               user_id:this.data.userid,
               name:this.data.nickName,
               idfront:this.data.new_img1,
               idback:this.data.new_img2,
               phone:this.data.nickphone,
               bslicense:this.data.new_img3
               },
             sCallback: function (res) {
         
               wx.showToast({
                 title: '修改成功',
                 icon: 'none',
                 duration: 2000
             })
             
             }
           }
           BaseObj.request(params);
           })
        }
        
       if (res.statusCode == 200) {
       wx.showToast({
         title: "上传成功",
         icon: "none",
       duration: 1500
         })
   }
      },
      fail: function (err) {
                              wx.showToast({
                                  title: "上传失败",
                                  icon: "none",
                                  duration: 2000
                              })
                          },
      });         
      }
    
     }
    this.foruserdata();
     //跳转到成功页面
     setTimeout(function () {
      this.onLoad()
      //要延时执行的代码
       wx.switchTab({
         url: '../tojoin/tojoin',
       })
    }, 1500) //延迟时间
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
  
   
   my.getusertoken((res) => {
    wx.setStorage({
      key: 'role',
      data: res.role,
      
     })
     console.log(wx.getStorageSync('role'))
    this.setData({
      userid:res.id,
      role:res.role,
      nickname:res.nickname,
      astatus:res.astatus,
     });
    })

 }
 else{
   my.getuser(dsr, (res) => {
    wx.setStorage({
      key: 'role',
      data: res.role,
     })
     console.log(wx.getStorageSync('role'))
     this.setData({
       userid:res.id,
     role:res.role,
     nickname:res.nickname,
     astatus:res.astatus,
    });
 })

 }

 },
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady() {

  },
  goback()
  {
this.setData(
  {
    etest:0
  }
)
  },
  betaker()
  {
  this.setData(
    {
      etest:2
    }
  )
console.log("我要当骑手")
  },
  bebuilder()
  {
    this.setData({
      etest:1
    })
  console.log("我要当店长")
  },
  _loadData: function() {
    var that=this;
    this.foruserdata();
    console.log(that.data.role)
    this._getOrders();

  },
  _getOrders: function(callback) {
    console.log(wx.getStorageSync('role'))
    if(wx.getStorageSync('role')==1)
    {
        order.getBossOrders(this.data.pageIndex, this.data.status,(res) => {
      var data = res.data;
      console.log(data);
      if (data.length) {
        this.data.orderArr.push.apply(this.data.orderArr, data);
        this.setData({
          orderArr: this.data.orderArr
        });
        //骑手
        this.data.qorderArr.push.apply(this.data.qorderArr, data);
        this.setData({
          qorderArr: this.data.qorderArr,
     
        });
        
  
      } else {
        this.setData({isLoadedAll:true})
      }
      callback && callback();
    });
    }
    else if(wx.getStorageSync('role')==2)
    {
      order.getqOrders(this.data.pageIndex,this.data.status,(res) => {
        var data = res.data;
        console.log(data);
        if (data.length) {
          this.data.orderArr.push.apply(this.data.orderArr, data);
          this.setData({
            orderArr: this.data.orderArr
          });
          //骑手
          this.data.qorderArr.push.apply(this.data.qorderArr, data);
          this.setData({
            qorderArr: this.data.qorderArr,
       
          });
          
    
        } else {
          this.setData({isLoadedAll:true})
        }
        callback && callback();
      });
    }
  
  },

  getOrderItem:function(e){
    var status = e.currentTarget.dataset.status;
    this.setData({status:status,orderArr:[],isLoadedAll:false,pageIndex:1});
    this._getOrders();
  },
    //去订单详情页面
    showOrderDetailInfo: function(event) {
      var id = order.getDataSet(event, 'id');
      wx.navigateTo({
        url: '../order/order?from=order&id=' + id,
      });
    },
    bshowOrderDetailInfo: function(event) {
      var id = order.getDataSet(event, 'id');
      wx.navigateTo({
        url: '../border/border?from=order&id=' + id,
      });
    },
    qshowOrderDetailInfo: function(event) {
      var id = order.getDataSet(event, 'id');
      console.log(this.id);
      wx.navigateTo({
        url: '../qorder/qorder?from=order&id=' + id,
      });
    },
     //历史订单的再次付款
  rePay: function(event) {
    var id = order.getDataSet(event, 'id'),
      index = order.getDataSet(event, 'index');
    this._execPay(id, index);
    // this.showTips('支付提示', '本产品仅用于演示，支付系统已屏蔽');
  },
  c_execPay: function(id,index) {
   console.log(id);
    order.cancel(id);
    wx.switchTab({
      url: '../my/my',
    })
  },
  _execPay: function(id, index) {
    console.log(id);
    var that = this;
    order.execPay(id, (statusCode) => {
      if (statusCode > 0) {
        var flag = statusCode == 2;

        //更新订单显示状态
        if (flag) {
          that.data.orderArr[index].status = 2;
          that.setData({
            orderArr: that.data.orderArr
          });
        }

        //跳转到成功页面
        wx.navigateTo({
          url: '../pay-result/pay-result?id=' + id + '&flag=' + flag + '&from=my',
        });
      } else {
        that.showTips('支付失败', '该商家不支持收款');
      }
    });
  },
  /**
   * 生命周期函数--监听页面显示
   */
  onShow() {
  wx.startPullDownRefresh();//开启自动刷新

      
    var newOrderFlag = order.hasNewOrder();
    if (newOrderFlag) {
      this.refresh();
    }
  },

  NameChange(e) {
    // event.detail 为当前输入的值
    var nickname = e.detail.value;
    this.setData({
      nickName: nickname
    })
    console.log(e.detail);
  },
  PhoneChange(e) {
    // event.detail 为当前输入的值
    var nickphone = e.detail.value;
    this.setData({
      nickphone: nickphone
    })
    console.log(e.detail);
  },
  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide() {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload() {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh() {

  },
 //重新加载历史订单
 refresh: function() {
  var that = this;
  this.data.orderArr = []; //订单初始化
  this._getOrders(() => {
    that.data.isLoadedAll = false; //是否加载完全
    that.data.index = 1;
    order.execSetStorageSync(false);
  });
},
  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom() {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage() {

  }
})