//Cipri build up a functionality for managing selected checkboxes

function chk_boxes(frm,box_name,chk_all_box_name){
    var frm_elem = frm.elements;
    var chk_bx_state = frm_elem[chk_all_box_name].checked;
    var pattern = new RegExp(box_name);
    for (var i=0;i<frm_elem.length;i++){
        var bx_name = new String(frm_elem[i].name);
        if(pattern.test(bx_name)){
            frm_elem[i].checked = chk_bx_state;
        }
    }
    return true;
}

function submit_form(frm,box_name,my_act,my_page,my_extra_attr){
    //evaluate the checked products first
    var chk_elems = 0;
    var try_del_master = 0;
    var frm_elem = frm.elements;
    var pattern = new RegExp(box_name+'_');
    for (var i=0;i<frm_elem.length;i++){
        var bx_name = new String(frm_elem[i].name);
        //alert(!(frm_elem[i].alt == 'master' && my_act == 'delete'));
        if(pattern.test(bx_name) && frm_elem[i].checked == true){
            if(!(frm_elem[i].alt == 'master' && my_act == 'delete')){
                chk_elems++;
            }
            else{
                frm_elem[i].checked = false;
                try_del_master = 1;
            }
        }
    }

    if(my_act != "" && chk_elems > 0){
        frm.action.value = my_act;
        frm.page.value = my_page;
        if(my_extra_attr != ""){
            frm.extra_attr.value = my_extra_attr;
        }
        frm.submit();
        return true;
    }
    else{
        if(chk_elems == 0 && !try_del_master){
            alert("Please select at least one item to apply your action!");
        }
        else{
            alert("You are not allowed to delete the MASTER parameter!\n\rPlease select other items for deletion!");
        }
        return false;
    }
}
function submit_form_sort(frm,my_act,my_page,my_extra_attr,my_sort){
    //evaluate the checked products first

    if(my_act != ""){
        frm.action.value = my_act;
        frm.page.value = my_page;
        if(my_sort != ""){
            frm.sort.value = my_sort;
        }
        frm.submit();
        return true;
    }
}
function submit_form_sort2(frm,my_act,my_page,my_extra_attr,my_sel_field,my_sort){
    //evaluate the checked products first

    if(my_act != ""){
        frm.action.value = my_act;
        frm.page.value = my_page;
        if(my_sort != ""){
            frm.sort.value = my_sort;
        }
        frm.submit();
        return true;
    }
}
function submit_form_param(frm,box_name,my_act,my_page){
    //evaluate the checked products first
    var chk_elems = 0;
    var frm_elem = frm.elements;
    var pattern = new RegExp(box_name+'_');
    for (var i=0;i<frm_elem.length;i++){
        var bx_name = new String(frm_elem[i].name);
        
        if(pattern.test(bx_name) && frm_elem[i].checked == true){
            if(my_act == 'delete'){
                chk_elems++;
            }
            else{
                frm_elem[i].checked = false;
            }
        }
    }

    if(my_act != "" && (chk_elems > 0 || my_act=="save" || my_act=="build" || my_act=="updatecombinations")){
        frm.action.value = my_act;
        
        frm.submit();
        return true;
    }
    else{
        if(chk_elems == 0){
            alert("Please select at least one item to apply your action!");
        }
        return false;
    }
}

$(function(){
	$("#lista table tr").dblclick(function(){
		el_id = $(this).find("td :checkbox").val().replace('c','');
		page = $("#list :input[name=page]").val();
		if(page && page != 'voucher_codes' && page != 'product_price' && page != 'alerts' && page != 'applicants' && page != 'reviews' && page != 'user_activity'){
			window.location.href = 'index.php?page='+page+'_form&action=edit&do_action=1&l_id_'+el_id+'='+el_id;
		}
	})
});