import {
  Base
} from '../utils/base.js';

class Category extends Base {
  constructor() {
    super();
  }

  //获得所有分类
  getCategoryType(Callback) {
    var params = {
      url: 'category/all',
      method: 'GET',
      sCallback: function(res) {
        Callback && Callback(res);
      }
    }
    this.request(params);
  }
//获得所有分类
getCategorydType(Callback) {
  var params = {
    url: 'category/dall',
    method: 'GET',
    sCallback: function(res) {
      Callback && Callback(res);
    }
  }
  this.request(params);
}
  //获得某种分类的商品
  getProductsByCategory(id, Callback) {
    var that = this;
    var dparams = {
      url: 'product/by_category?id=' + id,
      method: 'GET',
      sCallback: function(res) {
        Callback && Callback(res);
      },
      eCallback:function(res){
        Callback && Callback(0);
      }
    }
    this.request(dparams);
  }
  //获得供应商食品

}

export {
  Category
};