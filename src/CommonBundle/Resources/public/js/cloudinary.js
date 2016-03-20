
    var API_KEY = '146447182555489';
    var CLOUD_NAME = 'dnm1l8ric';

    var Cloudinary;

    Cloudinary = {

        init: function (options) {
            $.cloudinary.config({"api_key": API_KEY, "cloud_name": CLOUD_NAME});
            console.log('Cloudinary Init()...');
            this.startUpload(options);
        },
        startUpload: function(options){
            $('.cloudinary-fileupload').change( function() {
                console.log('Start uploading...');

                $('.cloudinary-fileupload').unsigned_cloudinary_upload(options.preset, {
                    cloud_name: CLOUD_NAME
                });
            })
        },
        uploadDone: function(callback){
            $('.cloudinary-fileupload').bind('cloudinarydone', function(e, data) {
                callback(data);
            })
        },
        uploadProgress: function(callback){
            $('.cloudinary-fileupload').bind('cloudinaryprogress', function(e, data) {
                callback(data);
            })
        }
    };