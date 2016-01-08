/**
    * DHTML date validation script. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/)
    */
    // Declaring valid date character, minimum year and maximum year
    var dtCh= "/";
    var minYear=1900;
    var maxYear=2100;

    function isInteger(s){
    var i;
    for (i = 0; i < s.length; i++){
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
    }

    function stripCharsInBag(s, bag){
    var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++){
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
    }

    function daysInFebruary (year){
        // February has 29 days in any year evenly divisible by four,
        // EXCEPT for centurial years which are not also divisible by 400.
        return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
    }
    function DaysArray(n) {
        for (var i = 1; i <= n; i++) {
            this[i] = 31
            if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
            if (i==2) {this[i] = 29}
        }
    return this
    }

    function isDate(dtStr){
        var daysInMonth = DaysArray(12)
        var pos1=dtStr.indexOf(dtCh)
        var pos2=dtStr.indexOf(dtCh,pos1+1)
        var strMonth=dtStr.substring(0,pos1)
        var strDay=dtStr.substring(pos1+1,pos2)
        var strYear=dtStr.substring(pos2+1)
        strYr=strYear
        if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
        if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
        for (var i = 1; i <= 3; i++) {
            if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
        }
        month=parseInt(strMonth)
        day=parseInt(strDay)
        year=parseInt(strYr)
        if (pos1==-1 || pos2==-1){
            //alert("Formatul datei trebuie sa fie : mm/dd/yyyy")
            return false
        }
        if (strMonth.length<1 || month<1 || month>12){
            //alert("Va rog introduceti o luna valida")
            return false
        }
        if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
            //alert("Va rog introduceti o zi valida")
            return false
        }
        if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
            //alert("Va rog introduceti un an valid cuprins intre "+minYear+" si "+maxYear)
            return false
        }
        if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
            //alert("Va rog introduceti o data valida")
            return false
        }
    return true
    }

    //Check to see if pickup date is valid and a future date
    function dateValid(effDateYear,effDateMonth,effDateDay){
        //get current date
        var sysDate = new Date();

        if(effDateDay < 10){
            effDateDay = '0'+effDateDay;
        }

        if(effDateMonth < 10){
            effDateMonth = '0'+effDateMonth;
        }

        var dateStr = effDateMonth+'/'+effDateDay+'/'+effDateYear;
        if (isDate(dateStr)==false){
                //dt.focus();
                alert("Data introdusa nu este valida!");
                //frm.add_wishalertday.focus();
                return false;
        }
        else{
            var effDateDate = new Date(effDateYear,effDateMonth-1,effDateDay);
            // compare the 2 dates
            if (effDateDate < sysDate){
                alert("Data introdusa nu reprezinta o data din viitor!");
                //frm.fld.focus();
                return false;
            }
            return true;
        }
    }