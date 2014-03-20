/**
 * Categories js file.
 *
 * Handles javascript stuff related to category function.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     API Controller
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */

$(document).ready(function() {
    // Initialise the table
	$("#categorySort").tableDnD({
		dragHandle: "col-drag-handle",
		onDragClass: "col-drag",
		onDrop: function(table, row) {
			var rows = table.tBodies[0].rows;
			var categoriesArray = [];
			for (var i=0; i<rows.length; i++) {
				categoriesArray[i] = rows[i].id;
			}
			var categories = categoriesArray.join(',');
			$.post("<?php echo url::site() . 'admin/manage/category_sort/' ?>", { categories: categories },
				function(data){
					if (data == "ERROR") {
						alert("Invalid Placement!!\n You cannot place a subcategory on top of a category.");
					} else {
						$("#categorySort"+" tbody tr td").effect("highlight", {}, 500);
					}
			});
		}
	});

    $("#parent_id").change(function () {
        $this = $(this).val();
        $("#category_position").val("0");
        if ($this == 0 || $this == null) {
            $("#category_position").val("0");
            $("#hide").addClass("hide");
            $("#child_id :not(:first)").remove();
            return false;
        } else {
            $.ajax({
                url: "<?php echo url::site() .'admin/manage/get_childrens_array/' ?>"+$this,
                type: "POST",
                success: function (list)
                {
                    $.each(list, function(i, item) {
                         $("#child_id").append("<option value="+i+">"+item+"</option>");
                    });
                }
            });
            $("#hide").removeClass("hide");
            $("#child_id :not(:first)").remove();
        }
    });

    $("#child_id").on("change",function() {
        $("#category_position").attr('value', $(this).val());
        $("#children").attr('value', $(this).val());
    });

	$("#categorySort tr").hover(function() {
		$(this.cells[0]).addClass('col-show-handle');
	}, function() {
		$(this.cells[0]).removeClass('col-show-handle');
	});

	$('a#category_translations').click(function() {
		$('.category_translations_form_fields').toggle(400);
		return false;
	});

	$('#category_color').ColorPicker({
		onSubmit: function(hsb, hex, rgb) {
			$('#category_color').val(hex);
		},
		onChange: function(hsb, hex, rgb) {
			$('#category_color').val(hex);
		},
		onBeforeShow: function () {
			$(this).ColorPickerSetColor(this.value);
		}
	})
	.bind('keyup', function(){
		$(this).ColorPickerSetColor(this.value);
	});
});

// Categories JS
function fillFields(event)
{
	params = event.data;
	show_addedit();

    $.ajax({
        url: "<?php echo url::site() .'admin/manage/get_childrens_array/' ?>"+params.parent_id,
        type: "POST",
        success: function (list)
        {
            if( params.parent_id == 0) {
                $("#child_id").find("option").remove(":not(:first)");
                return false;
            }
            $("#child_id").find("option").remove();
            $.each(list, function(i, item) {
                $("#child_id").append('<option value="'+i+'" class="child_'+i+'">'+item+'</option>');
                if(i == params.child_id ) {
                   $(".child_"+i).attr("selected", true);
                }
            });
            $("#child_id").prepend("<option value='0'>-- Children Level Category --</option>");
        }
    });

    $("#hide").removeClass("hide");
    $("#category_position").attr("value", params.category_position);
    $("#child_id").attr("value", params.child_id);

	$("#category_id").attr("value", params.category_id);
	$("#parent_id").attr("value", params.parent_id);
	$("#category_title").attr("value", params.category_title);
	$("#category_description").attr("value", params.category_description);
	$("#category_color").attr("value", params.category_color);
	$(".category_lang").show();
	$(".category_lang_"+params.locale).hide();
	$.each(params.category_langs, function (lang_key, value) {
		$("#category_title_"+lang_key).attr("value",value['category_title']);
		$("#category_description_"+lang_key).attr("value",value['category_description']);
		if (value['category_title'] != '')
		{
			$('.category_translations_form_fields').show();
		}
	});
}

// Ajax Submission
function catAction ( action, confirmAction, id )
{
	var statusMessage;
	var answer = confirm('<?php echo Kohana::lang('ui_admin.are_you_sure_you_want_to'); ?> ' + confirmAction + '?')
	if (answer){
		// Set Category ID
		$("#category_id_action").attr("value", id);
		// Set Submit Type
		$("#category_action").attr("value", action);
		// Submit Form
		$("#catListing").submit();
	}
}