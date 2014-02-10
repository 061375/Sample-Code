<!DOCTYPE HTML>
<html>
	<head>
		<title>061375.com Content Management System</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="Web Developer located in Southern California" />
		<meta name="keywords" content="PHP,LAMP,MYSQL,HTML,Javascript,JQuery,Wordpress,Codeigniter,Joomla,Expression Engine,Windows,Linux,Unix,Mac,GIT,Subversion,SVN,GIT Lab,SEO,Penguin,3D,Blender,Anim8or,Flash,Animation,Game Development, Wildomar, California" />
		<?php echo $header.$footer.$javascript.$css; ?>
		<script type="text/javascript" language="javascript" src="<?=base_url()?>js/data_tables/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" src="<?=base_url()?>js/datepicker/js/jquery.ui.core.js"></script>
		<script type="text/javascript" language="javascript" src="<?=base_url()?>js/datepicker/js/jquery.ui.widget.js"></script>
		<script type="text/javascript" language="javascript" src="<?=base_url()?>js/datepicker/js/jquery.ui.datepicker.js"></script>
		<script type="text/javascript" language="javascript" src="<?=base_url()?>js/cms.js"></script>
		<script type="text/javascript" language="javascript" src="<?=base_url()?>js/tinymce/js/tinymce/tinymce.js"></script>
		<script>
			$(document).ready(function(){
				CMS.getArticles($('#articles_container'));
				CMS.initDataTable($('#articles'));
				$( "#date1" ).datepicker();
				$( "#date2" ).datepicker();
				
				tinymce.init({
					selector:'textarea',
					toolbar: "save | undo redo | styleselect | bold italic | link image",
					plugins: "save,image,link",
					save_enablewhendirty: true,
					save_onsavecallback: function() {CMS.saveArticle();}
				});
			}); 
		</script>
		<style>
			#date_container
			{
				background:#c5634e;
				margin: 3px 0 3px 0;
				padding: 5px;
				color: #fff;
				text-shadow: 1px 1px 5px #fff;
				height: 50px;
			}
			#date_container .selected_date
			{
				float:left;
			}
			#date_container .change_date
			{
				cursor:pointer;
				float:right;
				padding: 0 5px 0 5px;
				border-radius: 3px;
				border: thin solid #ebecec;
				background: rgb(221,221,221); /* Old browsers */
				/* IE9 SVG, needs conditional override of 'filter' to 'none' */
				background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2RkZGRkZCIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjUlIiBzdG9wLWNvbG9yPSIjYzU2MzRlIiBzdG9wLW9wYWNpdHk9IjEiLz4KICAgIDxzdG9wIG9mZnNldD0iNjQlIiBzdG9wLWNvbG9yPSIjOTY0OTNjIiBzdG9wLW9wYWNpdHk9IjEiLz4KICAgIDxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iIzU5NGEyMyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgPC9saW5lYXJHcmFkaWVudD4KICA8cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMSIgaGVpZ2h0PSIxIiBmaWxsPSJ1cmwoI2dyYWQtdWNnZy1nZW5lcmF0ZWQpIiAvPgo8L3N2Zz4=);
				background: -moz-linear-gradient(top,  rgba(221,221,221,1) 0%, rgba(197,99,78,1) 5%, rgba(150,73,60,1) 64%, rgba(89,74,35,1) 100%); /* FF3.6+ */
				background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(221,221,221,1)), color-stop(5%,rgba(197,99,78,1)), color-stop(64%,rgba(150,73,60,1)), color-stop(100%,rgba(89,74,35,1))); /* Chrome,Safari4+ */
				background: -webkit-linear-gradient(top,  rgba(221,221,221,1) 0%,rgba(197,99,78,1) 5%,rgba(150,73,60,1) 64%,rgba(89,74,35,1) 100%); /* Chrome10+,Safari5.1+ */
				background: -o-linear-gradient(top,  rgba(221,221,221,1) 0%,rgba(197,99,78,1) 5%,rgba(150,73,60,1) 64%,rgba(89,74,35,1) 100%); /* Opera 11.10+ */
				background: -ms-linear-gradient(top,  rgba(221,221,221,1) 0%,rgba(197,99,78,1) 5%,rgba(150,73,60,1) 64%,rgba(89,74,35,1) 100%); /* IE10+ */
				background: linear-gradient(to bottom,  rgba(221,221,221,1) 0%,rgba(197,99,78,1) 5%,rgba(150,73,60,1) 64%,rgba(89,74,35,1) 100%); /* W3C */
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#dddddd', endColorstr='#594a23',GradientType=0 ); /* IE6-8 */
			} 
			#articles_container
			{
				padding: 10px;
				margin: 10px;
			}
			.dataTables_length
			{
				float:left;
			}
			.dataTables_filter
			{
				float: right;
			}
			#articles_next
			{
				padding:5px;
				float:right;
				cursor:pointer;
			}
			#articles_previous
			{
				padding:5px;
				float:left;
				cursor:pointer;
			} 
			h1
			{
				margin: 10px;
				font-size: 35px;
				font-weight: bold;
			}
			table th 
			{
				text-align: left;
				padding: 2px;
				font-weight: bold;
			}
			table tr 
			{
				font-size: 15px;
				padding: 2px;
			}
			table td 
			{	
				border: solid thin #bcc3c3;
				padding: 2px;
			}
			.h_list 
			{
				margin: 0;
			}
			.h_list ul
			{
				margin-bottom: 0;
			}
			.h_list li
			{
				cursor: pointer;
				float: left;
				margin: 0;
				padding: 0 15px 0 15px;
				font-size: 15px;
			}
			.articles_summary
			{
				padding:10px;
			}
			#cms_articles_edit
			{
				margin: auto;
				width: 90%;
			}
			#cms_articles_textarea
			{
				margin: auto;
				width: 100%;
				height: 300px;
			}
			.subtle_button
			{
				border:solid thin #B2B2B2;
				border-radius: 5px;
				box-shadow: 0px 2px 1px #B2B2B2;
				background: rgb(255,255,255); /* Old browsers */
				/* IE9 SVG, needs conditional override of 'filter' to 'none' */
				background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIxMyUiIHN0b3AtY29sb3I9IiNmZmZmZmYiIHN0b3Atb3BhY2l0eT0iMSIvPgogICAgPHN0b3Agb2Zmc2V0PSI1MSUiIHN0b3AtY29sb3I9IiNlYWVhZWEiIHN0b3Atb3BhY2l0eT0iMSIvPgogICAgPHN0b3Agb2Zmc2V0PSIxMDAlIiBzdG9wLWNvbG9yPSIjZjJmMmYyIiBzdG9wLW9wYWNpdHk9IjEiLz4KICA8L2xpbmVhckdyYWRpZW50PgogIDxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9InVybCgjZ3JhZC11Y2dnLWdlbmVyYXRlZCkiIC8+Cjwvc3ZnPg==);
				background: -moz-linear-gradient(top,  rgba(255,255,255,1) 13%, rgba(234,234,234,1) 51%, rgba(242,242,242,1) 100%); /* FF3.6+ */
				background: -webkit-gradient(linear, left top, left bottom, color-stop(13%,rgba(255,255,255,1)), color-stop(51%,rgba(234,234,234,1)), color-stop(100%,rgba(242,242,242,1))); /* Chrome,Safari4+ */
				background: -webkit-linear-gradient(top,  rgba(255,255,255,1) 13%,rgba(234,234,234,1) 51%,rgba(242,242,242,1) 100%); /* Chrome10+,Safari5.1+ */
				background: -o-linear-gradient(top,  rgba(255,255,255,1) 13%,rgba(234,234,234,1) 51%,rgba(242,242,242,1) 100%); /* Opera 11.10+ */
				background: -ms-linear-gradient(top,  rgba(255,255,255,1) 13%,rgba(234,234,234,1) 51%,rgba(242,242,242,1) 100%); /* IE10+ */
				background: linear-gradient(to bottom,  rgba(255,255,255,1) 13%,rgba(234,234,234,1) 51%,rgba(242,242,242,1) 100%); /* W3C */
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#f2f2f2',GradientType=0 ); /* IE6-8 */

			}
		</style>
	</head> 
	<body style="display:none">
		<h1>
			061375.com Content Management System
		</h1>
		<div id="date_container">
			<span class="selected_date">
				<?=date('l F jS, Y')?>
			</span>
			<span class="change_date spots_modal" spots_modal-url="ajax/modal/datepicker" spots_modal-class="fader_black mybasic_modal">
				<span class="general foundicon-calendar"></span> 
				Change Date Range
			</span>
		</div>
		<div id="summary_selection_container" class="h_list">
			<ul>
				<li class="articles">
					<span class="general foundicon-plus"></span> Articles
				</li>
				<li class="administrator">
					<span class="general foundicon-plus"></span> Administrator
				</li> 
				<li style="float:right" class="spots_modal" spots_modal-url="ajax/modal/generaltext/about analytics" spots_modal-class="fader_black mybasic_modal">
					<span class="general foundicon-idea"></span> About
				</li>
				<li style="float:right">
					<span class="general foundicon-location"></span> <a href="<?=base_url()?>profile/logout">Logout</a>
				</li>
			</ul>
			<div class="clear"></div>
		</div>
		<div id="cms_articles" class="">
			<div class="h_list">
				<ul>
					<li id="article_view_button" class="subtle_button nav_button">
						<span class="general -foundicon-plus"></span> List Articles
					</li>
					<li id="article_edit_button" class="subtle_button nav_button">
						<span class="general -foundicon-plus"></span> Add / Edit Articles
					</li>
				</ul>
			</div>
			<div class="clear"></div>
			<div id="article_view" class="article_section">
				<h1>
					Articles
				</h1>
				<div id="articles_container" class="hidden">
					
				</div>
			</div>
			<div id="article_edit" class="h_list hidden article_section">
				<h1 class="fltleft">
					Add / Edit Articles
				</h1>
				<span class="fltright" style="width:60%">
					<label for="article_title">
						Title
					</label>
					<input type="text" style="width: 50%" id="article_title" />
					Section
					<select style="margin: 30px 30px auto" id="article_section">
						<option value="">-- Select One --</option>
						<option value="">Testing</option>
						<option value="">Testing</option>
						<option value="">Testing</option>
						<option value="">Testing</option>
						<option value="">Testing</option>
					</select>
				</span>
				<div class="clear"></div>
				<div id="cms_articles_edit">
					<textarea id="cms_articles_textarea"></textarea>	
				</div>
			</div>
		</div>
		<div id="cms_administrator" class="hidden">
		</div>
		<div id="confirmation_key" style="display:none"><?=$confirmation_key?></div>
		<div id="base_url" style="display:none"><?=base_url()?></div>
		<div id="start_date" style="display:none"><?=strtotime($first_post_date)?></div>
		<div id="end_date" style="display:none"><?=strtotime('tomorrow')?></div>
	</body>
</html>