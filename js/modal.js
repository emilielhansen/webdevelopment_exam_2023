 // Get the modal
 var modal = document.getElementById("my_modal");

 // Get the button that opens the modal
 var btn = document.getElementById("openModalBtn");

 // Get the <span> element that closes the modal
 var span = document.querySelector(".close");

 // When the user clicks the button, open the modal
 btn.onclick = function () {
   modal.classList.remove("hidden");
 };

 // When the user clicks on <span> (x), close the modal
 span.onclick = function () {
   modal.classList.add("hidden");
 };

 // When the user clicks anywhere outside of the modal, close it
 window.onclick = function (event) {
   if (event.target === modal) {
     modal.classList.add("hidden");
   }
 };