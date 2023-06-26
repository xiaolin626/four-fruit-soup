// pages/toCash/toCash.js
import {
  Base
} from '../utils/base.js';

var BaseObj = new Base();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    test:0,
    id:'',
    cantake_money:'',
    mobile:'',
    money:'',
    max_withdraw:200,
    min_withdraw:0,
  },
  bindKeyInput: function(e) {
    console.log(e.detail)
    this.setData({
      money: e.detail.value
    })
  },
  getAllMoney() {
    this.setData({
      money: this.data.cantake_money
    })
  },
  goback()
  {
    wx.redirectTo({
      url: '../tomyself/tomyself',
    })
    console.log("回到个人信息")
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad(options) {
    this.setData({
      mobile: options.mobile,
      cantake_money:options.money,
      id:options.id,
  })
 
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady() {

  },
  appletMemberWithdraw(){
    this.setData({
      test:1,
    })
      var params = {
        url: 'cashs/money',
        data:{
          money:this.data.money,
          mobile:this.data.mobile,
          id:this.data.id
        },
        type:'post',
        sCallback: function(res) {
          Callback && Callback(res);
        }
      }
      BaseObj.request(params);

  },
  /**
   * 生命周期函数--监听页面显示
   */
  onShow() {

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