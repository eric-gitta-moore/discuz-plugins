var swfu_s3;
$(function() {
	var settings = {
		upload_url: "source/plugin/oss/lib/upload.php",
		file_post_name: "s3_file",
		file_size_limit: "200 MB",
		file_types: "*.*",
		file_types_description: "All Files",
		file_upload_limit: "0",
		file_queue_limit: "1",
		swfupload_loaded_handler: swfUploadLoaded,
		file_dialog_start_handler: fileDialogStart,
		file_queued_handler: fileQueued,
		file_queue_error_handler: fileQueueError,
		file_dialog_complete_handler: fileDialogComplete,
		upload_progress_handler: uploadProgress,
		upload_error_handler: uploadError,
		upload_success_handler: uploadSuccess,
		upload_complete_handler: uploadComplete,
		button_image_url: "source/plugin/oss/css/browse_button.png",
		button_placeholder_id: "spanButtonPlaceholder",
		button_width: 73,
		button_height: 29,
		flash_url: "source/plugin/oss/js/swfupload.swf",
		custom_settings: {
			progress_target: "fsUploadProgress",
			upload_successful: false
		},
		debug: false
	}
	swfu_s3 = new SWFUpload(settings);
});