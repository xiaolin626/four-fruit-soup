import {
  Base
} from '../utils/base.js';

class User extends Base{
  constructor() {
    super();
  }

   //获得用户信息
   getuser(usr,Callback) {
    var params = {
      url: 'User/'+usr,
      method: 'GET',
      sCallback: function(res) {
        Callback && Callback(res);
      }
    }
    this.request(params);
  
  }
  getusertoken(usr,Callback) {
    var params = {
      url: 'User/by_token'+usr,
      method: 'GET',
      sCallback: function(res) {
        Callback && Callback(res);
      }
    }
    this.request(params);
  
  }
 
}

export {User};