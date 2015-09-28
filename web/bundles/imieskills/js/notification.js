//$(function () {
//    var notification = $(".notification");
//    notification.on('click', function () {
//        alert('test');
//        var exist = 0;
//        console.log(exist === 0);
//        if (exist === 0) {
//
//            var div = document.create('div');
//            notification.append(div);
//            alert('ok');
//            exist = 1;
//        }
//    });
//});
var notification = document.getElementById('notification');
console.log(notification);
var div = document.createElement("div");
div.className= "notification_div";
notification.addEventListener('click', function () {
    document.body.appendChild(div);
    console.log("success");
    div.innerHTML= "notification envoyée";
});


