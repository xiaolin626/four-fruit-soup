//时间戳转换成时间 formatTimeTwo(last_day_Tamp / 1000, 'Y-M-D h:m:s')
function formatTimeTwo(number, format) {
 
  var formateArr = ['Y', 'M', 'D', 'h', 'm', 's'];
  var returnArr = [];
 
  var date = new Date(number * 1000);
  returnArr.push(date.getFullYear());
  returnArr.push(formatNumber(date.getMonth() + 1));
  returnArr.push(formatNumber(date.getDate()));
 
  returnArr.push(formatNumber(date.getHours()));
  returnArr.push(formatNumber(date.getMinutes()));
  returnArr.push(formatNumber(date.getSeconds()));
 
  for (var i in returnArr) {
    format = format.replace(formateArr[i], returnArr[i]);
  }
  return format;
}

function formatNumber(n) {
  n = n.toString()
  return n[1] ? n : '0' + n
}


module.exports = {  
  formatTimeTwo: formatTimeTwo  
 }  
 