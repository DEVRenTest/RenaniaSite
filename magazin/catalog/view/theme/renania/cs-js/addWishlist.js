//check the fields mandatory for adding wishlist opperation
    function addWish(frm){

        //count the selected products, so I know if I need to execute the delete action or not
        if(document.getElementById("add_wishtitle").value != '' && document.getElementById("add_wishdescription").value != ''){

            if(document.getElementById("add_wishsendalert").checked){
                var pickYear = document.getElementById("add_wishalertyear").value;
                var pickMonth = document.getElementById("add_wishalertmonth").value;
                var pickDay = document.getElementById("add_wishalertday").value;

                //check to see if this date is valid
                if(dateValid(pickYear,pickMonth,pickDay)){
                    frm.submit();
                }
            }
            else{
                frm.submit();
            }
        }
        else if(document.getElementById("add_wishtitle").value == ''){
            alert("Va rog completati spatiul rezervat titlului wishlist-ului!");
            frm.add_wishtitle.focus();
        }
        else if(document.getElementById("add_wishdescription").value == ''){
            alert("Va rog completati spatiul rezervat descrierii wishlist-ului!");
            frm.add_wishdescription.focus();
        }
    }

    //set the rating for this wishlist
    function setRating(frm,rate_id){
        var begin_with= /^add_rating_/;
        var rpl_off_str= "emptystar";
        var rpl_on_str = "fullstar";

        //count the selected products, so I know if I need to execute the delete action or not
        for(i=1;i<=5;i++){
            var idname = "add_rating_"+i;
            var myimg = document.getElementById(idname);
            var old_src = myimg.src;
            var new_src = old_src.replace(rpl_off_str,rpl_on_str);

            //from this start up above put it off
            if(i>rate_id){
                new_src = old_src.replace(rpl_on_str,rpl_off_str);
            }
            document.getElementById("add_rating_"+i).src = new_src;
        }

        //set the commnet rating
        frm.add_cmtrating.value = rate_id;
    }