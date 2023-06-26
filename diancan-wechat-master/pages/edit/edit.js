
import {
  Base
} from '../utils/base.js';
import {
  Category
} from '../food/food-model.js';
var category = new Category;
const app = getApp();
var BaseObj = new Base();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    dename:"原料",
    categoryTypeArr: [{}],
    site:'0',
    dcategoryTypeArr: {},
    id:0,
    show: false,
    name: '',
    price:'',
    stock:'',
    category_id:'',
    dtype:app.globalData.edittype
    },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function(options) {
    category.getCategorydType((categoryData) => {
     
      this.setData({
            categoryTypeArr: categoryData
          });
        })
        console.log(this.data.categoryTypeArr)
        
  },
  showPopup() {
    this.setData({
      show: true
    });
  },
  //获取用户信息

  toIssue()
  {
 
    console.log(this.data.categoryTypeArr[this.data.site].id);
    var params = {
      url: 'product/b_pro',
      type:'post',
      data:{
      name:this.data.name,
      price:this.data.price,
      stock:this.data.stock,
      category_id:this.data.categoryTypeArr[this.data.site].id
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
        title: '修改失败，请查看是否为空',
        icon: 'none',
        duration: 2000
    })
    }}
    BaseObj.request(params);
     

  },
  watchSite(e) {

    this.setData({
     site: e.detail.value
    })
 },
  onChange(event) {
    const {
      picker,
      value,
      index
    } = event.detail;
    // Toast(`当前值：${value}, 当前索引：${index}`);
  },
  onClose() {
    this.setData({
      show: false
    });
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
    var Name = e.detail.value;
    this.setData({
     name: Name
    })
    console.log(e.detail);
  },
  psdChange(e) {
    // event.detail 为当前输入的值
    var Price = e.detail.value;
    this.setData({
     price:Price
    })
    console.log(e.detail);
  },
  mobileChange(e) {
    // event.detail 为当前输入的值
    var Stock = e.detail.value;
    this.setData({
      stock: Stock
    })
    console.log(e.detail);
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
   * 生命周期函数--监听页面卸载
   */
  onUnload: function() {

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