// pages/order/order.js

import {
  Cart
} from '../cart/cart-model.js';

import {
  Order
} from '../order/order-model.js';

import {
  Address
} from '../utils/address.js';
import {Config} from '../utils/config.js';

var cart = new Cart();
var address = new Address();
var order = new Order();


Page({

  /**
   * 页面的初始数据
   */
  data: {
    setTime: null, //定时器
    //订单编号id，有则订单生成成功，没就失败
    id: null,
    //选择店食还是外卖，1外卖，2店食
    selectAddressStatus: 1,
    //第一次支付，可以生成订单，但是不能付款，之后都不能支付了
    firstPayStatus:1,
    //来源是哪里
    fromUrl: null,

    addressInfo:[],
    isNoAddressData:true,

    ustatus:'',

    picBaseUrl:Config.picUrl
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function(options) {
    var from = options.from;
    this.setData({
      fromUrl: from
    });
    if (from == 'cart') {
      this._fromCart(options.account);
    }
    else{
      var id = options.id;
      this.setData({
        id: id
      });
      this._fromOrder(id);
    }
  },
  onShow: function(option) {
    if(this.data.id){
      this._fromOrder(this.data.id);
    }
    //显示收货地址
    var that = this;
    address.getAddress((res) => {
      var isNoAddressData = true;
      console.log(res);
      if(Object.keys(res).length>0){
        isNoAddressData = false;
      }
      that.setData({
        addressInfo: res,
        isNoAddressData:isNoAddressData
      });
  
    });
  },
  callMobile:function(e){
    console.log("点击了该方法");
      var mobile =e.currentTarget.dataset['index'];
      wx.showModal({
        title: '您要拨打的电话为',
        content: mobile,
        success: function (res) {
          if (res.confirm) {
            wx.makePhoneCall({
              phoneNumber: mobile,
            })
          }
        }
      })
  },
  _fromCart(account) {
    var productsArr;
    this.data.account = account;

    productsArr = cart.getCartDataFromLocal(true);
    this.setData({
      productsArr: productsArr,
      account: account,
      orderStatus: 0,
      ustatus:data.ustatus,
    });
  },

  _fromOrder(id) {
    if (id) {
      //下单后，支付成功或者失败，点击左上角返回时能够更新订单状态，所以放在onshow中
      var that = this;
      //访问服务器，根据订单id获取数据库中订单信息
      order.getOrderInfoById(id, (data) => {
        that.setData({
          orderStatus: data.status,
          ustatus:data.ustatus,
          productsArr: data.snap_items,
          account: data.total_price,
          basicInfo: {
            orderTime: data.create_time,
            orderNo: data.order_no
          }
        });

        //快照地址
        var addressInfo = data.snap_address;
        addressInfo.totalDetail = address.setAddressInfo(addressInfo);
        that._bindAddressInfo(addressInfo);

      });
    }
  },

 //绑定地址信息
 _bindAddressInfo: function(addressInfo) {
  this.setData({
    addressInfo: addressInfo
  });
},

  testPay:function(event){
    this.showTips('支付提示', '本产品仅用于演示，支付系统已屏蔽');
  },
  /*
   *提示窗口
   *title-{string}标题
   *content{string}内容
   *flag{bool}是否跳转到我的页面
   */
  showTips: function(title, content, flag) {
    wx.showModal({
      title: title,
      content: content,
      showCancel: false,
      success: function(res) {
        if (flag) {
          wx.switchTab({
            url: '/pages/my/my',
          })
        }
      }
    })
  },
  startTimer : function(){
    var that = this;
    that.data.timer = setTimeout(
        function () {
            
            console.log('startTimer  500毫秒后执行一次任务')
        }, 500);    
  },
  /**
   * 结束定时器
   */
  endTimer: function(){
    var that = this;
    clearTimeout(that.data.timer)
  },










  //下单与支付
  pay: function() {
    
  this.d_execPay(this.data.id);

  },

  

  d_execPay: function(id, index) {
    var that = this;
  
      order.changeOrderstute7(that.data.id)
        //更新订单显示状态
           //that.data.orderArr[index].take_time=formatTimeTwo(that.data.orderArr[index].take_time,'Y-M-D h:m:s');
          that.data.orderStatus = 7;
         
          if(that.data.ustatus==1)
          {
            this.showTips('完成订单','配送费已返回钱包，请前往查看');
          }
          else if(that.data.ustatus==0)
          {
            this.showTips('完成订单', '请等待用户确认订单');
          }
          //定时三十分钟，访问后端查看是否被确认
          that.data.timer = setTimeout(
              function () {
                order.checkOrderstute(that.data.id)
                  console.log('startTimer  30分钟后执行一次任务')
              }, 6*300000);   
  
  },
  
})