// pages/category/category.js
import { formatTimeTwo } from '../utils/timestamp';

import {
  Category
} from 'food-model.js';
import {
  My
} from '../my/my-model.js';
import {
  Order
} from '../order/order-model.js';

import {Cart} from "../cart/cart-model.js"
import { Base } from '../utils/base.js';
var category = new Category;
var cart = new Cart();
var BaseObj = new Base();
var app = getApp();
var order = new Order();
var my = new My();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    categoryTypeArr: {},
    categoryProducts: {},
    currentMenuIndex: 0,
    loadedData: {},
    bannerArr:[],
    orderArr: [],
    qorderArr: [],

    pageIndex: 1,
    is_nodata:false,  
    nav_act_content:1, //控制显示 菜品或者商家
    sysData:'', //系统数据
    recommendProduct:[],
    dProduct:[],
    bannerHeight:0,
    navHeight:0,
    categoryBoxHeight:0,


    //用户信息
    status:0,
    usr:"",
    qid:'',
    role:"123",
    nickname:"456",

  },
  onShow(){
    wx.startPullDownRefresh();//开启自动刷新
  },
  onPullDownRefresh(){
   this.refresh();
  },
//重新加载历史订单
refresh: function() {
  var that = this;
  this.data.orderArr = []; //订单初始化
  this.data.qorderArr = []; //订单初始化
  this._getOrders(() => {
    that.data.isLoadedAll = false; //是否加载完全
    that.data.index = 1;
    order.execSetStorageSync(false);
  });
},
  //接单
  rePay: function(event) {
    var id = order.getDataSet(event, 'id'),
      index = order.getDataSet(event, 'index');
    this._execPay(id, index);
  },
  qrePay: function(event) {
    var id = order.getDataSet(event, 'id'),
      index = order.getDataSet(event, 'index');
    this.q_execPay(id, index);
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
_execPay: function(id, index) {
  var that = this;

    order.changeOrderstute5(that.data.orderArr[index].id,this.data.qid)
      //更新订单显示状态
         //that.data.orderArr[index].take_time=formatTimeTwo(that.data.orderArr[index].take_time,'Y-M-D h:m:s');
        that.data.orderArr[index].status = 5;
        that.setData({
          orderArr: that.data.orderArr
        });
      //跳转到成功页面
      wx.switchTab({
        url: "/pages/food/food",
      });
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
  wx.navigateTo({
    url: '../qorder/qorder?from=order&id=' + id,
  });
},
q_execPay: function(id, index) {
  var that = this;
  order.changeOrderstute6(that.data.qorderArr[index].id,this.data.qid)
      //更新订单显示状态
        that.data.qorderArr[index].status = 6; 
        that.setData({
          qorderArr: that.data.qorderArr
        });
      //跳转到成功页面
      wx.switchTab({
        url: "/pages/food/food",
      });
},
getOrderItem:function(e){
  var status = e.currentTarget.dataset.status;
  this.setData({status:status,orderArr:[],isLoadedAll:false,pageIndex:1});
  this._getOrders();
},
  /**
   * 生命周期函数--监听页面加载
   */
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
   my.getusertoken((res) => {
    wx.setStorage({
      key: 'role',
      data: res.role,

     })
     console.log(wx.getStorageSync('role'))
    this.setData({
      role:res.role,
      nickname:res.nickname,
      qid:res.id,
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
     role:res.role,
     nickname:res.nickname,
     qid:res.id,
    });
 })

 }
 
 },
  onLoad: function(options) {
    
    this._loadData();
    this.getBanner();
    this.getClientHeight();
  },
 
  getBanner:function(){
    var that = this;
    var parame = {
      url : 'banner',
      sCallback:function(res){
        if(res.length >0 ){
          that.setData({bannerArr:res})
        }else{
          var bannerArr = [
            {'image':"../../imgs/baner1.jpg"},
            {'image':"../../imgs/baner2.jpg"}
          ];
          that.setData({bannerArr:bannerArr}) 
        }
      }
    };
    BaseObj.request(parame); 

    
   
  },

  getClientHeight:function(){
    var that = this;
    wx.getSystemInfo({
      success: (result) => {
        var screeHight = wx.getSystemInfoSync().windowHeight;//获取屏幕高度
        that.setData({clientHight:screeHight});
      },
    })
  },
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function() {
     
  },

  //判断当前分类下的商品数据是否已经被加载过
  isLoadedData: function(index) {
    if (this.data.loadedData[index]) {
      return true;
    }
    return false;
  },

  _loadData: function() {
    var that=this;
    this.foruserdata();
    console.log(that.data.role)
if(wx.getStorageSync('role')==0)
{
  category.getCategoryType((categoryData) => {
  this.setData({
        'categoryTypeArr': categoryData
      });
console.log(this.data.categoryTypeArr)
      //一定要在回调里再进行获取分类详情的方法调用
      category.getProductsByCategory(categoryData[0].id, (data) => {
        if(data == 0){
            var dataObj = {};
            var is_nodata = true;
        }else{
          var dataObj = {
            products: data,
            topImgUrl: categoryData[0].img.url,
            title: categoryData[0].name
          };
          var is_nodata = false;
        }
       
         
        //数据绑定
        this.setData({
          'categoryProducts': dataObj,
           is_nodata :is_nodata
        });
        //第一次加载保存到loadedData中
        this.data.loadedData[0] = dataObj;
      });
    })

}
else if(wx.getStorageSync('role')==1)
{
    category.getCategoryType((categoryData) => {
    this.setData({
      'categoryTypeArr': categoryData
    });
    //一定要在回调里再进行获取分类详情的方法调用
    category.getProductsByCategory(12, (data) => {
      if(data == 0){
          var dataObj = {};
          var is_nodata = true;
      }else{
        var dataObj = {
          products: data,
          topImgUrl: categoryData[0].img.url,
            title: categoryData[0].name
        };
        var is_nodata = false;
      }
     
       
      //数据绑定
      this.setData({
        'categoryProducts': dataObj,
         is_nodata :is_nodata
      });
      //第一次加载保存到loadedData中
      this.data.loadedData[0] = dataObj;
    })
  })
  
}
this._getOrders();
  },
  
  onProductsItemTap: function(event) {
    var id = category.getDataSet(event, 'id');
    wx.navigateTo({
      url: '../product/product?id=' + id,
    })
  },

  changeCategory: function(event) {
    var id = category.getDataSet(event, 'id');
    var index = category.getDataSet(event, 'index');

    this.setData({
      'currentMenuIndex': index
    });
    //内容回滚顶部
    var scrollTopUp = this.data.categoryBoxHeight == 0? 355:this.data.categoryBoxHeight;
    wx.pageScrollTo({
      scrollTop: scrollTopUp
    });

    if (!this.isLoadedData(index)) {
      //如果没有加载过当前分类的商品数据
      category.getProductsByCategory(id, (data) => {
        var dataObj = {};
        if(data == 0){
          var is_nodata = true;
        }else{
          var dataObj = {
            products: data,
            topImgUrl: this.data.categoryTypeArr[index].img.url,
            title: this.data.categoryTypeArr[index].name
          };
          var is_nodata = false;
        }
        // console.log(Object.keys(dataObj).length);
        this.setData({
          'categoryProducts': dataObj,
          'is_nodata' :is_nodata
        });
        //第一次加载保存到loadedData中
        this.data.loadedData[index] = dataObj;
      });

      
    } else {
      //不是第一次加载就使用loadedData
      var getData = this.data.loadedData[index];
      var is_nodata = false;
      if(Object.keys(getData).length == 0)
          is_nodata = true;
      this.setData({
        'categoryProducts': getData,
        is_nodata : is_nodata
      });
    }
  },
  onShow:function(){
    var that = this;
    setTimeout(function(){
      wx.setNavigationBarTitle({
        title: app.globalData.web_title
      })
      that.setData({sysData:app.globalData.sysData});
      
    },1000)
    setTimeout(function(){
      //获取nav 高度  页面加载完毕需要时间，所以延迟计算
      that.getNodeInfoById('navHeight');
      that.getNodeInfoById('categoryBoxHeight');
    },4000)
    //获取推荐
    if(wx.getStorageSync('role')==0)
    {
      this.getRecommendProduct();
    }
    else if(wx.getStorageSync('role')==1)
    {
      this.getdProduct();
    }
   
  },
  getRecommendProduct:function(res){
    var that = this;
    var parame ={
      url:'product/recommend',
      sCallback:function(res){
       if(Object.keys(res).length > 0){
          that.setData({recommendProduct:res})
       }  
      }
    };
    BaseObj.request(parame);
  },
  getdProduct:function(res){
    var that = this;
    var parame ={
      url:'product/getd',
      sCallback:function(res){
        console.log(res.data)
       if(Object.keys(res).length > 0){
          that.setData({dProduct:res})
       }  
      }
    };
    BaseObj.request(parame);
    console.log(that.data.dProduct)
  },
  stopMaopao:function(){
    console.log(1);
    return false;
  },
  tobyhand:function()
  {
    wx.navigateTo({
      url: '../byhand/byhand',
    })
  },
  toedit0:function()
  {
    app.globalData.edittype=0;
    wx.navigateTo({
      url: '../edit/edit',
    })
  },
  toedit1:function()
  {
    app.globalData.edittype=0;
    wx.navigateTo({
      url: '../edit/edit',
    })
  },
  toquik:function()
  {
    wx.navigateTo({
      url: '../byquik/byquik',
    })
  },
  addToCart: function(event) {
    var this_id = category.getDataSet(event, 'id');
    var category_id = category.getDataSet(event, 'category_id');
    var categoryProducts = this.data.categoryProducts;
    var products_arr = categoryProducts.products;
    var this_product = {};
    for(var i=0;i<products_arr.length;i++){
      var one_item = products_arr[i];
      if(one_item.id == this_id){
        this_product = one_item;
      }
    }
    // console.log(products_arr);
    var tempObj = {};
    var keys = ['id', 'name', 'main_img_url', 'price'];

    //遍历商品的详情数据对象,根据keys对tempObj赋值
    for (var key in this_product) {
      if (keys.indexOf(key) >= 0) {
        tempObj[key] = this_product[key];
      }
    }
    cart.add(tempObj, 1);
    BaseObj._showMessageToast('已加购物车');
  },
  choose_nav:function(e){
    var nav_act_content = category.getDataSet(e,'act')
    this.setData({nav_act_content:nav_act_content})
  },
  onPageScroll: function (e) {//监听页面滚动 
    console.log(e);
    this.setData({
      scrollTop: e.scrollTop
    })
  },


  // 获取页面节点信息的方法(nodeName 节点id名称)
  getNodeInfoById(nodeName) {
    var that = this;
    const query = this.createSelectorQuery();
    query.select(`#${nodeName}`).boundingClientRect();
    query.selectViewport().scrollOffset();
    query.exec(res => {
      console.log(res);//有 height top left width等
      if(nodeName == 'navHeight'){
        that.setData({navHeight:res[0].height});
      }
      if(nodeName == 'categoryBoxHeight'){
        that.setData({categoryBoxHeight:res[0].top});
      }
     
    });
  },
/**
   * 用户点击右上角分享
   */
  onShareAppMessage() {

  },

  callMobile:function(){
    var mobile = app.globalData.sysData.tel;
    // console.log(mobile);
    wx.makePhoneCall({
      phoneNumber: mobile,
    })
  },
})