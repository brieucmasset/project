var toastLiveExample = document.getElementById("liveToast");
if (toastLiveExample) {
  toastLiveExample.classList.add("show");
  var messages = toastLiveExample.children;
  for (var i = 0; i < messages.length; i++) {
    var message = messages[i];
    var progressBar = message.querySelector("#myBar");
    if (progressBar) {
      progressBar.max = 100;
      var value = 0;
      var intervalId = setInterval(function () {
        value += 5;
        progressBar.value = value;
        if (value >= 100) {
          clearInterval(intervalId);
          message.remove(message);
        }
      }, 150);
    }
  }
}
