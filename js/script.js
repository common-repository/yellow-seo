(function ($) {
	"use strict";

	updatePreview();

	if ($("#sseoDefaultMetaTitle").length) {
		$("#sseo_title_count").html('<strong>' + $("#sseoDefaultMetaTitle").val().length + '</strong>');
	}

	if ($("#sseoDefaultMetaDescription").length) {
		$("#sseo_desc_count").html('<strong>' + $("#sseoDefaultMetaDescription").val().length + '</strong>');
	}

	if ($("#sseoMetaTitle").length) {
		$("#sseo_title_count").html('<strong>' + $("#sseoMetaTitle").val().length + '</strong>');
	}

	if ($("#sseoMetaDescription").length) {
		$("#sseo_desc_count").html('<strong>' + $("#sseoMetaDescription").val().length + '</strong>');
	}

	$('#sseoMetaTitle').change(function () {
		var count = $(this).val().length;
		$("#sseo_title_count").html('<strong>' + count + '</strong>');
		updatePreview();
	});
	$('#sseoMetaTitle').keypress(function () {
		var count = $(this).val().length;
		$("#sseo_title_count").html('<strong>' + count + '</strong>');
		updatePreview();
	});
	$('#sseoMetaTitle').bind('paste', function () {
		var count = $(this).val().length;
		$("#sseo_title_count").html('<strong>' + count + '</strong>');
		updatePreview();
	});

	$('#sseoDefaultMetaTitle').change(function () {
		var count = $(this).val().length;
		$("#sseo_title_count").html('<strong>' + count + '</strong>');
	});
	$('#sseoDefaultMetaTitle').keypress(function () {
		var count = $(this).val().length;
		$("#sseo_title_count").html('<strong>' + count + '</strong>');
	});
	$('#sseoDefaultMetaTitle').bind('paste', function () {
		var count = $(this).val().length;
		$("#sseo_title_count").html('<strong>' + count + '</strong>');
	});

	$('#sseoMetaDescription').change(function () {
		var count = $(this).val().length;
		$("#sseo_desc_count").html('<strong>' + count + '</strong>');
		updatePreview();
	});
	$('#sseoMetaDescription').keypress(function () {
		var count = $(this).val().length;
		$("#sseo_desc_count").html('<strong>' + count + '</strong>');
		updatePreview();
	});
	$('#sseoMetaDescription').bind('paste', function () {
		var count = $(this).val().length;
		$("#sseo_desc_count").html('<strong>' + count + '</strong>');
		updatePreview();
	});

	$('#sseoMetaDescription').change(function () {
		var count = $(this).val().length;
		$("#sseo_desc_count").html('<strong>' + count + '</strong>');
		updatePreview();
	});
	$('#sseoMetaDescription').keypress(function () {
		var count = $(this).val().length;
		$("#sseo_desc_count").html('<strong>' + count + '</strong>');
		updatePreview();
	});
	$('#sseoMetaDescription').bind('paste', function () {
		var count = $(this).val().length;
		$("#sseo_desc_count").html('<strong>' + count + '</strong>');
		updatePreview();
	});

	$("#title").change(function () {
		updatePreview();
	});
	$("#title").keypress(function () {
		updatePreview();
	});
	$("#title").bind(function () {
		updatePreview();
	});

	//update the preview
	function updatePreview() {
		console.log('llandao');
		var featuredImage;
		var seo_image_preview = $('#sseo_snippet_img');

		$("#sseo_snippet_title").html('');

		if ($('.components-responsive-wrapper__content').length) {
			featuredImage = $('.components-responsive-wrapper__content').attr('src');
			seo_image_preview.attr("src", featuredImage);

		}

		if ($('#postimagediv img').length) {
			featuredImage = $('#postimagediv img').attr('src');
			seo_image_preview.attr("src", featuredImage);

		}

		var sseoMetaDescription = $.trim($("#sseoMetaDescription").val());
		if (sseoMetaDescription.length > 0) {
			$("#sseo_snippet_description").html(sseoMetaDescription);
		}

		var sseoMetaTitle = $.trim($("#sseoMetaTitle").val());
		if (sseoMetaTitle.length > 0) {
			$("#sseo_snippet_title").html(sseoMetaTitle);
		}

		if (sseoMetaTitle.length <= 0) {
			var title = $.trim($("#title").val());
			if (title.length > 0) {
				$("#sseo_snippet_title").html(title);
			}
		}
	}

})(jQuery);