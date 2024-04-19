var modal = document.getElementById('descriptionModal');

var span = document.getElementsByClassName("close")[0];

var images = document.getElementsByClassName("nft-image");
for (var i = 0; i < images.length; i++) {
    images[i].addEventListener('click', function() {
        var description = this.getAttribute('data-description');
        document.getElementById('descriptionText').innerText = description;
        modal.style.display = "block";
    });
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
