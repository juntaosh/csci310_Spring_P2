
function upload(img){
var clientId = "";
var imgUrl = "http://i.imgur.com/l5OqYoZ.jpg";

$.ajax({
    url: "https://api.imgur.com/3/image",
    type: "POST",
    datatype: "json",
    data: {image: img},
    success: showMe,
    error: showMe,
    beforeSend: function (xhr) {
        xhr.setRequestHeader("Authorization", "Client-ID 1bb316c19d65c0a");
    }
});

function showMe(data) {
    if(data.success == true) {
        console.log(data.data.link);
    }
  }
}