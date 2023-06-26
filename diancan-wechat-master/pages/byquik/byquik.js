// pages/byquik/byquik.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
filename:'',
path:'',
  },

  /**
   * 生命周期函数--监听页面加载
   */

    //获取FileSystemManger的全局唯一文件管理器
    onLoad: function (options) {
      
    },
    
   
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady() {

  },
  byQuikButton() {
    var that = this
    wx.chooseMessageFile({
      count: 1,
      type: 'file',
     success(res){
      
       var size=res.tempFiles[0].size;
       var filename=res.tempFiles[0].name;
       var newfilename=filename +"";
      //  console.log(res)
      console.log(newfilename);
       if(size>4194304||newfilename.indexOf(".txt")==-1)//判断上传文件类型
       {
         wx.showToast({
           title: '文件大小不能超过4MB,格式必须为txt文本',
           icon:"none",
           duration:2000,
           mask:true
         })
       }else
       {  
         that.setData({
           path:res.tempFiles[0].path,//路径保存到页面变量方便uploadfile调用
           filename:res.tempFiles[0].name//渲染到wxml让用户知道自己选择了什么文件
         }),()=>{
            console.log(that.data.path)
         console.log(that.data.filename)
         }
        
       }
     }
    })
  },

  submit()
  {
    var that=this;
    var filepath=that.data.path;
    wx.uploadFile({
      url: 'http://linzer626.com/api/v1/img/uptxt',   //上传的路径
      filePath:filepath, //刚刚在data保存的文件路径
      name: 'file',   //后台获取的凭据
      success() {
      wx.showToast({   //做个提示或者别的操作
       title: '',
       icon: "none",
       duration: 5000,
       mask: true,
       success: function (res) {
  
       }
      })
 },
 success:(res)=>{

 }
 })
 wx.showModal({
  content: '上传文件成功',
  showCancel: false,
  success: function(res) {
   
  }
})
setTimeout(function () {
  //要延时执行的代码
   wx.switchTab({
     url: '../food/food',
   })
}, 1500) //延迟时间
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