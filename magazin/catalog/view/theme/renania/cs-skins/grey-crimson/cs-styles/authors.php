<?php
header("Content-type: text/css");
include ('./config.php');

echo '

.authorletters {
	padding-left: '.$page_padding.'px;
	padding-top: '.$column_space.'px;
	padding-right: '.$page_padding.'px;
	padding-bottom: '.$column_space.'px;
	float: left;
	width: '.$pagenumbers_width.'px;
}

.authorletters a{
	display: block;
	width: '.$page_off_bg_width.'px;
	font-size: '.$page_off_size.'px;
	line-height: '.$page_off_size.'px;
	color: '.$page_off_color.';
	font-weight: '.$page_off_bold.';
	text-align: center;
	background: '.$page_off_bg.';
	padding-top: '.$page_on_bg_padding.'px;
	padding-bottom: '.$page_on_bg_padding.'px;
	float: left;
	margin-right: '.$page_elements_space_off.'px;
}

.authorletters a:hover{
	background: '.$page_off_bg_over.';
	text-decoration: '.$page_off_overunderline.';
}

.authorletters .LetterText {
	float: left;
	display: block;
	padding-top: '.$page_on_bg_padding.'px;
	padding-bottom: '.$page_on_bg_padding.'px;	
	font-size: '.$page_off_size.'px;
	line-height: '.$page_off_size.'px;	
	margin-right: '.$page_elements_space.'px;	
}

.authorletters .LetterOn{
	display: block;
	width: '.$page_on_bg_width.'px;
	font-size: '.$page_on_size.'px;
	line-height: '.$page_on_size.'px;
	color: '.$page_on_color.';
	font-weight: '.$page_on_bold.';
	text-align: center;
	background: '.$page_on_bg.';
	padding-top: '.$page_on_bg_padding.'px;
	padding-bottom: '.$page_on_bg_padding.'px;
	float: left;
	margin-right: '.$page_elements_space.'px;	
	margin-left: '.$page_elements_space.'px;	
}

.authorletters .PageInput {
	display: block;
	float: left;
	padding-left: 10px;
}

.authorletters .PageInput input {
	width: '.$page_input_width.'px;
	font-size: '.$page_input_size.'px;
	line-height: '.$page_input_size.'px;
	padding: '.$page_input_padding.'px;
	text-align: center;
}

.authorletters .PageGo,
.authorletters .PageGo:hover {
	width: '.$page_butt_width.'px;
	height: '.$page_butt_height.'px;
	background: '.$page_butt_bg.';	
	padding: 0px;
	margin-left: 2px;	
}

.authorletters .PageNext,
.authorletters .PageNext:hover {
	width: '.$page_next_width.'px;
	height: '.$page_next_height.'px;
	background: '.$page_next_bg.';	
	padding: 0px;
	margin-left: 2px;	
}

.authorletters .PagePrev,
.authorletters .PagePrev:hover {
	width: '.$page_prev_width.'px;
	height: '.$page_prev_height.'px;
	background: '.$page_prev_bg.';	
	padding: 0px;
	margin-left: 10px;	
}

#MiddleColumn a.author {
	float: left;
	width: '.$author_width.'px;
	font-weight: bold;
	text-align: left;
	padding: '.$column_space.'px;
}

';
?>
