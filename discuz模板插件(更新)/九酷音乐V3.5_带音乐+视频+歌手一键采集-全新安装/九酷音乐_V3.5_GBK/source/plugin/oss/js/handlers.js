function swfUploadLoaded() {}
function uploadDone() {
	try {} catch(ex) {
		alert("Error submitting form");
	}
}
function fileDialogStart() {
	var txtFileName = document.getElementById("FileInput");
	txtFileName.value = "";
	this.cancelUpload();
}
function fileQueueError(file, errorCode, message) {
	try {
		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED:
			alert("You have attempted to queue too many files.\n" + (message === 0 ? "You have reached the upload limit.": "You may select " + (message > 1 ? "up to " + message + " files.": "one file.")));
			return;
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			alert("The file you selected is too big.");
			this.debug("Error Code: File too big, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			return;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			alert("The file you selected is empty.  Please select another file.");
			this.debug("Error Code: Zero byte file, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			return;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			alert("The file you choose is not an allowed file type.");
			this.debug("Error Code: Invalid File Type, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			return;
		default:
			alert("An error occurred in the upload. Try again later.");
			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			return;
		}
	} catch(e) {}
}
function fileQueued(file) {
	try {
		var txtFileName = document.getElementById("FileInput");
		txtFileName.value = file.name;
	} catch(e) {}
}
function fileDialogComplete(numFilesSelected, numFilesQueued) {}
function uploadProgress(file, bytesLoaded, bytesTotal) {
	try {
		var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);
		file.id = "singlefile";
		var progress = new FileProgress(file, this.customSettings.progress_target);
		progress.setProgress(percent);
		progress.setStatus("上传中...");
	} catch(e) {}
}
function uploadSuccess(file, serverData) {
	try {
		file.id = "singlefile";
		var progress = new FileProgress(file, this.customSettings.progress_target);
		progress.setComplete();
		progress.setStatus("正在返回...");
		progress.toggleCancel(false);
		if (serverData === " ") {
			this.customSettings.upload_successful = false;
		} else {
			this.customSettings.upload_successful = true;
			ReturnValue(serverData);
		}
	} catch(e) {}
}
function uploadComplete(file) {
	try {
		if (this.customSettings.upload_successful) {
			this.setButtonDisabled(true);
			uploadDone();
		} else {
			file.id = "singlefile";
			var progress = new FileProgress(file, this.customSettings.progress_target);
			progress.setError();
			progress.setStatus("File rejected");
			progress.toggleCancel(false);
			var txtFileName = document.getElementById("txtFileName");
			txtFileName.value = "";
			alert("There was a problem with the upload.\nThe server did not accept it.");
		}
	} catch(e) {}
}
function uploadError(file, errorCode, message) {
	try {
		if (errorCode === SWFUpload.UPLOAD_ERROR.FILE_CANCELLED) {
			return;
		}
		var txtFileName = document.getElementById("txtFileName");
		txtFileName.value = "";
		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.MISSING_UPLOAD_URL:
			alert("There was a configuration error.  You will not be able to upload a resume at this time.");
			this.debug("Error Code: No backend file, File name: " + file.name + ", Message: " + message);
			return;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			alert("You may only upload 1 file.");
			this.debug("Error Code: Upload Limit Exceeded, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			return;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			break;
		default:
			alert("An error occurred in the upload. Try again later.");
			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			return;
		}
		file.id = "singlefile";
		var progress = new FileProgress(file, this.customSettings.progress_target);
		progress.setError();
		progress.toggleCancel(false);
		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			progress.setStatus("Upload Error");
			this.debug("Error Code: HTTP Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			progress.setStatus("Upload Failed.");
			this.debug("Error Code: Upload Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			progress.setStatus("Server (IO) Error");
			this.debug("Error Code: IO Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			progress.setStatus("Security Error");
			this.debug("Error Code: Security Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			progress.setStatus("Upload Cancelled");
			this.debug("Error Code: Upload Cancelled, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			progress.setStatus("Upload Stopped");
			this.debug("Error Code: Upload Stopped, File name: " + file.name + ", Message: " + message);
			break;
		}
	} catch(ex) {}
}
$(function() {
	$("#s3_upload_form").live('submit',
	function(e) {
		isValid = true;
		FileInput = $("#FileInput").val();
		error_msg = "";
		if (FileInput == "" || FileInput == "未选择文件") {
			error_msg += "请点击Browse选择文件";
			isValid = false;
		}
		if (isValid === false) {
			$("#up_file").html(error_msg);
			$("#up_status").html('等待上传');
		} else {
			swfu_s3.addPostParam("bucket_name", $("#bucket_name").find("option:selected").val());
			swfu_s3.addPostParam("perm", $('input[name=perm]:checked', '#s3_upload_form').val());
			swfu_s3.startUpload();
		}
		e.preventDefault();
	});
	$(".reload").click(function() {
		window.location.href = window.location.href;
		return false;
	});
});