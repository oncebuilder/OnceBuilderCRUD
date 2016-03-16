/**
 * Version: 1.0, 29.07.2015
 * by Adam Wysocki, support@oncebuilder.com
 *
 * Copyright (c) 2015 Adam Wysocki
 *
 *	This is OnceBuilder Types plugin (once.types)
 *
*/

once.types = {
	loaded: false,
	initialized: function(){
		this.loaded=true;
	},
	// Load type
	typeLoad: function(obj){
		// Remove all highlights
		$(".list-group-item").removeClass("current");
		// Highlight selected object
		obj.addClass("current");
		var c=$("div[data-c]");
		// Call for items list with selected type
		$.get(once.path+"/view.php?c="+$(c).data("c")+"&o="+$(c).data("o")+"&type_id="+obj.data("id"), function(data) {
			$("#content-body").html(data);
		})
		.error(function() { console.log("Request Error: "+$(c).data("o")); });
	},
	// Add new type
	typeNew: function(obj){
		// Get c name
		var c=$("div[data-c]");
		// Call to create new type
		$.ajax({
			type: 'POST',
			url: once.path+"/ajax.php?c=core&o=type_new&module="+$(c).data("c"),
			success: function(data) { 
				// Refresh items list if response ok
				if(data.status=='ok'){
					var id=data.item.id;
					// Call to open new type then click edit it.
					$.get(once.path+"/view.php?c=types&o=list&module="+$(c).data("c")+"&id="+id, function(data) {
						$("#types-data").html(data);
						// Call for items list with selected type
						$(".list-group-item.current").click();
						$(".list-group-item.current .edit-item-type").click();
					})
					.error(function() { console.log("Request Error: types"); });
				}else{
					console.log("Action Error: "+data.error);
				}
			},
			contentType: "application/json",
			dataType: 'json'
		})
		.error(function() { console.log("Request Error: type_delete"); });
	},
	// Delete type
	typeDelete: function(obj){
		// Get c name
		var c=$("div[data-c]");
		var li=obj.parent().parent();
		var name=li.find("span").html();
		// We need to confirm to delete
		var r = confirm("Delete "+name+"?");
		if(r){
			// Call to create new type
			$.ajax({
				type: 'POST',
				url: once.path+"/ajax.php?c=core&o=type_delete&id="+li.data("id")+"&module="+$(c).data("c"),
				success: function(data) { 
					// Check if its current then click or load it directly
					if(li.hasClass("current")){
						if(li.parent().find('li').length>0){
							$(".list-group-item:first").click();
						}else{
							$.get(once.path+"/view.php?c=types&o=list&id=0", function(data) {
								$("#content-body").html(data);
							});
						}
						li.remove();
					}else{
						li.remove();
					}
				},
				contentType: "application/json",
				dataType: 'json'
			})
			.error(function() { console.log("Request Error: type_delete"); });
		}
	},
	// Delete edit type
	typeEditDelete: function(obj){
		// Get c name
		var c=$("div[data-c]");
		// Get varibles defined in rendering data-*
		var id=$("#type-data").data('id');
		var name=$("#type_"+id+" span").html();
		// We need to confirm to delete
		var r = confirm("Delete "+name+"?");
		if(r){
			// Call to del_layer with parm id
			$.ajax({
				type: 'POST',
				url: once.path+"/ajax.php?c=core&o=type_delete&id="+id+"&module="+$(c).data("c"),
				success: function(data) { 
					// Refresh items list if response ok
					if(data.status=='ok'){
						$("#type-data .item-close").click();
						// Intermediatly delete from dom then refresh items list
						$("#type_"+id).remove();
					}else{
						console.log("Action Error: "+data.error);
					}
				},
				contentType: "application/json",
				dataType: 'json'
			})
			.error(function() { console.log("Request Error: type_delete"); });
		}
	},
}

once.types.actions = {
	// Initialize type Init
	typeInit: function(obj){
		if(!once.types.loaded){
			// Initialize form for edit
			once.loadJSfile(once.path+'/js/jquery.form.js');
			
			// Initialize on click
			$("#types-data li.list-group-item").click(function (e) {
				e.preventDefault();
				e.stopPropagation();
				once.types.typeLoad($(this));
			});
			// Only creators & admin can make new types
			if(once.creator || once.admin){
				// Make hover working on types if exist
				if($(this).find(".list-group-hover")){
					$(".list-group-item").hover(
						function(){
							$(this).find(".list-group-hover").show(); //.fadeIn(250)
						},
						function(){
							$(this).find(".list-group-hover").hide(); //.fadeOut(205)
						}
					);
				}
				
				$(".list-group").sortable({
					items: ".list-group-item",
					update: function (event, ui) {
						var data = $(this).sortable("serialize");
						event.stopPropagation();
						//ui.item.attr("data-id")
						// POST to server using $.post or $.ajax
						var c=$("div[data-c]");
						$.ajax({
							data: data,
							type: "POST",
							url: "ajax.php?c=core&o=type_sort&module="+$(c).data("c")
						});
					}
				});
			}
			
			// Initialize edit type dialog
			once.types.dialogs.typeEdit(".type-edit");
		
			$("#type-new").click(function () {
				once.types.typeNew($(this));
			});
			
			$(".list-group-item .type-delete").click(function (e) {
				e.preventDefault();
				e.stopPropagation();
				once.types.typeDelete($(this));
			});
			
			//once.types.loaded=true;

			//setTimeout("$(\".list-group-item .type-edit:first\").click();",500);
		}
	},
	// Initialize types dialog
	typeEdit: function(obj){
		if(!once.types.loaded){
			// Save item
			$("#type-data .item-save").click(function () {
				$("#typeForm").submit();
			});

			// Delete item
			$("#type-data .item-delete").click(function () {
				once.types.typeEditDelete($(this));
			});
		
			// Initialize typeForm
			once.types.forms.typeForm($(this));
			
			// Set loaded
			once.types.loaded=false;
		}
	},
}

once.types.dialogs = {
	// Open dialog mode
	typeEdit: function(obj){
		// Append at end of the body
		$("body").append("<div id=\"type-edit\"></div>");

		// Read and open edit dialog
		$(obj).click(function (e) {
			e.preventDefault();
			e.stopPropagation();
			var c=$("div[data-c]");
			$("#type-edit").load(once.path+"/dialog.php?c=types&o=edit&module="+$(c).data("c")+"&id="+$(this).parent().parent().data("id"), function() {
				$('#type-edit .modal:first').modal({
					show: 'false'
				}); 
			})
			.error(function() { console.log("Dialog Error: type edit"); });
		});
	},
}

once.types.forms = {
	// Initialize type form
	typeForm: function(obj){
		var c=$("div[data-c]");
		$("#typeForm").attr("action",once.path+"/ajax.php?c=core&o=type_edit&module="+$(c).data("c")+"&id="+$("#type-data").data("id"));
		var options = {
			dataType:  "json",
			success: function(data){
				// If response ok 
				if(data.status=='ok'){
					if($("#type-data").data('redirect')==undefined){
						// Update name & ico on items list
						var name=$("#typeForm input[name='name']");
						var ico=$("#typeForm input[name='ico']");
						
						// Update DOM
						$("#type_"+data.item.id+" .list-group-header span").html(name.val());
						$("#type_"+data.item.id+" .list-group-header i").attr('class', ico.val());;
					}
					console.log("Type updated!");
				}else{
					console.log("Action Error: "+data.error);
				}
			},
			complete: function(){
				//console.log(data.responseText);
			},
			error: function(){
				console.log("Form Error: typeForm");
			}
		};
		$("#typeForm").ajaxForm(options);
	},
}

$(document).ready(function () {
	// Initialize types actions
	if($("#types-data").length){
		once.types.actions.typeInit();
	}
});