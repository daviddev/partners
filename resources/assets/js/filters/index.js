import Vue from "vue"

Vue.filter("amount", number => {
    if(number || number == 0){
       let result = '';
       let i =1;
       let len = number.toString().split(".")[0].length;
       let decimal
       if(number.toString().split(".")[1] && number.toString().split(".")[1].length == 2){
           decimal = number.toString().split(".")[1];
       } else if (number.toString().split(".")[1] && number.toString().split(".")[1].length == 1){
           decimal = number.toString().split(".")[1]+"0";
       }else{
           decimal = "00";
       }
       for(let item of number.toString().split(".")[0]) {
           result += item;
           if((len - i) % 3 == 0 && i != len) {
               result += ',';
           }
           if(i == len) result += '.' + decimal
           i++;
       }
       return result
   } else{
       return number;
   }
})
