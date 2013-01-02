$(document).ready(function () {
	$('#uploader').fineUploader({
		request: {
			endpoint: '/change/photo/'
		},
		text: {
            retryButton: '',
            failUpload: '',
			dropProcessing: '',
			uploadButton: 'Добавить фото<i></i>'
		},
		template:'<span class="qq-upload-button">{uploadButtonText}</span><ul class="qq-upload-list" style="display:none;"></ul>',
		debug: true
	});
});