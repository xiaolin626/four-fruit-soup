import {
  Base
} from '../utils/base.js';
var BaseObj = new Base();
class My extends Base {
  constructor() {
    super();
  }
  //获得用户信息
  getuser(usr,Callback) {
   var kparams = {
      url: 'User/'+usr,
      method: 'GET',
      sCallback: function(res) {
        Callback && Callback(res);
      }
    }

    this.request(kparams);
  
  }
  getusertoken(Callback) {
    var dparams = {
      url: 'User/by_token',
      type: 'get',
      sCallback: function(res) {
        Callback && Callback(res);
      }
    }
    BaseObj.request(dparams); 
  
  }
 
  



  
}

export {
  My
};