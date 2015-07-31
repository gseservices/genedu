var monthNames = [
        "January", "February", "March",
        "April", "May", "June", "July",
        "August", "September", "October",
        "November", "December"
        ];

// returns date in 07-July-2015 format
function getTodaysDateFormatted(){
        var date = new Date();
        var day = date.getDate();
        var monthIndex = date.getMonth();
        var year = date.getFullYear();
       
       return day + '-' + monthNames[monthIndex] + '-' +year;
} // -- getTodaysDataFormatted --


// only supports : 07-July-2015 format
function getMySqlDate(dateString){
        var arr = dateString.split('-');
        var day = arr[0];
        var month = monthNames.indexOf(arr[1]);
        var year = arr[2];
        
        return year + '-' + (month+1) + '-' + day;
} // -- getMySqlDate -- 
//debugControl
var logs_on = true;
var log_type = "console";
//Prams: msg, is_imp, log_type
function debugLog(){
        var msg, is_imp, log_type_now;
        if(arguments.length >0){
                for (var i =0; i<arguments.length; i++){
                        if (i==0)
                                msg = arguments[i];
                        else if(i==1)
                                is_imp = arguments[i];
                        else if(i==2)
                                log_type_now = arguments[i];;
                }
                
                if (msg == "")
                        return;
                if (is_imp === undefined)
                        is_imp = false;
                if (logs_on || is_imp){
                        switch(log_type){
                                case "console":
                                        console.log(msg);
                                        break;
                                case "alert":
                                        alert(msg);
                                        break;
                                case "both":   
                                        console.log(msg);
                                        alert(msg);
                                        break;
                        }
                }
        }else{
                return;               
        }
}

