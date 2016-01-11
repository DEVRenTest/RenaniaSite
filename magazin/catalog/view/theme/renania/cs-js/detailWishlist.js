//check the fields on updating wishlist
    function saveWishlist(frm){
        var pickYear    = document.getElementById("upd_wishalertyear").value;
        var pickMonth   = document.getElementById("upd_wishalertmonth").value;
        var pickDay     = document.getElementById("upd_wishalertday").value;

        //check to see if this date is valid
        if(dateValid(pickYear,pickMonth,pickDay)){
            //verify the title and the description
            if(document.getElementById("upd_wishtitle").value != '' && document.getElementById("upd_wishdescription").value != ''){
                frm.do_act.value = 'update_wishlist';
                frm.submit();
            }
            else if(document.getElementById("upd_wishtitle").value == ''){
                alert("Va rog completati spatiul rezervat titlului wishlist-ului!");
                frm.upd_wishtitle.focus();
            }
            else{
                alert("Va rog completati spatiul rezervat descrierii wishlist-ului!");
                frm.upd_wishdescription.focus();
            }
        }
    }

    //check if user selected a product to be deleted
    function delProd(frm){
        var matched = 0;
        var begin_with= /^prod_/;

        //count the selected products, so I know if I need to execute the delete action or not
        for(i=0;i<frm.length;i++){
            if(frm.elements[i].name.match(begin_with) && frm.elements[i].checked){
                matched++;
            }
        }
        if(matched > 0){
            frm.do_act.value = 'del_prod';
            frm.submit();
        }
        else{
            alert("Va rog selectati cel putin un produs pentru a executa aceasta operatie!");
        }
    }

    //check if user selected a product to be added to basket
    function addProdBasket(frm){
        var matched = 0;
        var begin_with= /^prod_/;

        //count the selected products, so I know if I need to execute the delete action or not
        for(i=0;i<frm.length;i++){
            if(frm.elements[i].name.match(begin_with) && frm.elements[i].checked){
                matched++;
            }
        }
        if(matched > 0 || frm.empty_basket.checked){
            frm.do_act.value = 'add_prod_basket';
            frm.submit();
        }
        else{
            alert("Va rog selectati cel putin un produs pentru a executa aceasta operatie!");
        }
    }

    //set the rating for this wishlist
    function setRating(frm,rate_id){
        var begin_with= /^rating_/;

        var rpl_off_str= "emptystar";
        var rpl_on_str = "fullstar";

        //count the selected products, so I know if I need to execute the delete action or not
        for(i=1;i<=5;i++){
            var idname = "rating_"+i;
            var myimg = document.getElementById(idname);
            var old_src = myimg.src;
            var new_src = old_src.replace(rpl_off_str,rpl_on_str);

            //from this start up above put it off
            if(i>rate_id){
                new_src = old_src.replace(rpl_on_str,rpl_off_str);
            }
            document.getElementById("rating_"+i).src = new_src;
        }

        //set the commnet rating
        frm.comment_rating.value = rate_id;
    }

    //check the fields related with the add comment opperation
    function addComment(frm){
        //count the selected products, so I know if I need to execute the delete action or not
        if(document.getElementById("comment").value != '' && document.getElementById("cmtusername").value != '' && verifyEmail(frm)){
            frm.do_act.value = 'add_comment';
            if(document.getElementById('cmtemail').value == 'nume@domeniu.ro'){
                    document.getElementById('cmtemail').value = '';
            }
            frm.submit();
        }
        else if(document.getElementById("comment").value == ''){
            alert("Va rog completati spatiul rezervat commentariului!");
            frm.comment.focus();
        }
        else if(document.getElementById("cmtusername").value == ''){
            alert("Va rog completati numele si prenumele dumneavoastra!");
            frm.cmtusername.focus();
        }
    }

    //check the length of the email field
    function verifyEmail(frm){
        if(document.getElementById('cmtabonare').checked){
            if (!(document.getElementById('cmtemail').value.indexOf(' ')==-1 && 0<document.getElementById('cmtemail').value.indexOf('@') && document.getElementById('cmtemail').value.indexOf('@')+1 < document.getElementById('cmtemail').value.length ) || document.getElementById('cmtemail').value == 'nume@domeniu.ro'){
                alert("Adresa de email introdusa nu este valida. Va rugam sa corectati erorile si sa incercati din nou.");
                document.getElementById('cmtabonare').checked == "false";
                if(document.getElementById('cmtemail').value != 'nume@domeniu.ro'){
                    document.getElementById('cmtemail').value = 'nume@domeniu.ro';
                }
                return false;
            }
        }
        return true;
    }

    //clear the email field
    function clearEmail(frm){
        if(frm.cmtemail.value != ''){
            frm.cmtemail.value = '';
            frm.cmtemail.focus;
        }
    }