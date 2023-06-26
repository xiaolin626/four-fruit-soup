import {
  Base
} from '../utils/base.js';
var BaseObj = new Base();
class Order extends Base {
  constructor() {
    super();
    this._storageKeyName = 'newOrder';
  }

 //下订单
 doOrder(param, callback) {
  var that = this;
  var allParams = {
    url: 'order',
    type: "POST",
    data: {
      products: param
    },

    sCallback: function(data) {
      that.execSetStorageSync(true);
      callback && callback(data);
    },
    eCallback: function() {}
  };
  this.request(allParams);
}
//取消订单
cancel(orderNumber, callback) {
  var that = this;
  var allParams = {
    url: 'order/cancel',
    type: "get",
    data: {
     id: orderNumber
    },

    sCallback: function(data) {
    wx.showToast({
      title: '取消订单成功',
    })
    },
    eCallback: function() {
      wx.showToast({
        title: '取消订单失败',
      })
    }
  };
  this.request(allParams);
}
  //更改订单5 已接单
  changeOrderstute5(orderNumber,qid, callback) {
    var allParams = {
      url: 'order/changeorder5',
      type: 'get',
      data: {
        id: orderNumber,
        qid:qid
      },
      sCallback: function(data) {
        console.log("修改成功")
      },
      eCallback:function (res) {
        console.log(res);
      }
    };
    this.request(allParams);
  }
  //更改订单5 完成中
  changeOrderstute6(orderNumber,qid, callback) {
    var allParams = {
      url: 'order/changeorder6',
      type: 'get',
      data: {
        id: orderNumber,
        qid:qid
      },
      sCallback: function(data) {
        console.log("修改成功")
      },
      eCallback:function (res) {
        console.log(res);
      }
    };
    this.request(allParams);
  }
   //更改订单5 已接单
   changeOrderstute7(orderNumber, callback) {
    var allParams = {
      url: 'order/changeorder7',
      type: 'get',
      data: {
        id: orderNumber
      },
      sCallback: function(data) {
        console.log("修改成功")
      },
      eCallback:function (res) {
        console.log(res);
      }
    };
    this.request(allParams);
  }
  checkOrderstute(orderNumber,callback)
  {
    var allParams = {
      url: 'order/checkOrderstute',
      type: 'get',
      data: {
        id: orderNumber
      },
      sCallback: function(data) {
        console.log("修改成功")
      },
      eCallback:function (res) {
        console.log(res);
      }
    };
    this.request(allParams);
  }
   //更改订单5 已接单
   changeOrderstuteu(orderNumber,account, callback) {
    var allParams = {
      url: 'order/changeorderu',
      type: 'get',
      data: {
        id: orderNumber,
        account:account
      },
      sCallback: function(data) {
        wx.showModal({
          title: '售货成功',
          content: '请享用美味四果汤',
          showCancel: false,
          success: function(res) {
           
          }
        })
        setTimeout(function () {
          //要延时执行的代码
           wx.switchTab({
             url: '../my/my',
           })
        }, 1500) //延迟时间
      },
      eCallback:function (res) {
        wx.showModal({
          title: '收货失败',
          content:'骑手还未抢单，请勿过早收货',
          showCancel: false,
          success: function(res) {
           
          }
        })
      }
    };
    this.request(allParams);
  }
  //更改订单5 已接单
  changeOrderstuteQuit(orderNumber, callback) {
    var allParams = {
      url: 'order/changeorderQuit',
      type: 'get',
      data: {
        id: orderNumber,   
      },
      sCallback: function(data) {
        wx.showModal({
          title: '取消成功',
          content: '感谢您的使用',
          showCancel: false,
          success: function(res) {
           
          }
        })
        setTimeout(function () {
          //要延时执行的代码
           wx.switchTab({
             url: '../my/my',
           })
        }, 1500) //延迟时间
      },
      eCallback:function (res) {
        wx.showModal({
          title: '取消失败',
          content:'请重新操作',
          showCancel: false,
          success: function(res) {
           
          }
        })
      }
    };
    this.request(allParams);
  }
  //本地缓存保存更新
  execSetStorageSync(data) {
    wx.setStorageSync(this._storageKeyName, data);
  }

  //支付
  execPay(orderNumber, callback) {
    var allParams = {
      url: 'pay/pre_order',
      type: 'post',
      data: {
        id: orderNumber
      },
      sCallback: function(data) {
        var timeStamp = data.timeStamp;
        if (timeStamp) {
          //可以支付
          wx.requestPayment({
            timeStamp: timeStamp.toString(),
            nonceStr: data.nonceStr,
            package: data.package,
            signType: data.signType,
            paySign: data.paySign,
            success: function() {
              callback && callback(2);
            },
            fail: function() {
              callback && callback(2);
            }
          });
        } else {
          callback && callback(0);
        }
      },
      eCallback:function (res) {
        console.log(res);
      }
    };
    this.request(allParams);
  }

  //根据订单编号获取订单信息的具体内容
  getOrderInfoById(id, callback) {
    var that = this;
    var allParams = {
      url: 'order/' + id,
      type: 'get',
      sCallback: function(data) {
        callback && callback(data);
      },
      eCallback: function() {}
    };

    this.request(allParams);
  }

  //获得所有历史订单信息，从1开始
  getOrders(pageIndex, status,callback) {
    var that = this;
    var allParams = {
      url: 'order/by_user',
      data: {
        page: pageIndex,
        status:status
      },
      type: 'get',
      sCallback: function(data) {
        callback && callback(data);
      }
    };

    this.request(allParams);
  }
 //获得所有历史订单信息，从1开始
 getBossOrders(pageIndex, status,callback) {
  var that = this;
  var allParams = {
    url: 'order/boss',
    data: {
      page: pageIndex,
      status:status
    },
    type: 'get',
    sCallback: function(data) {
      callback && callback(data);
    }
  };

  this.request(allParams);
}
 //获得所有历史订单信息，从1开始
 getqOrders(pageIndex, status,callback) {
  var that = this;
  var allParams = {
    url: 'order/q',
    data: {
      page: pageIndex,
      status:status,
    },
    type: 'get',
    sCallback: function(data) {
      console.log(data);
      callback && callback(data);
    }
  };

  this.request(allParams);
}
  //是否有新的订单
  hasNewOrder(){
    var flag = wx.getStorageSync(this._storageKeyName);
    return flag == true;
  }


}

export {
  Order
};