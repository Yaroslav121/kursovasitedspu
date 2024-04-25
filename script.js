var modal = document.getElementById("orderModal");
var span = document.getElementsByClassName("close")[0];

function orderCar(carId) {
    var modal = document.getElementById('orderModal');
    var form = document.getElementById('orderForm');
    
    form.reset();
    document.getElementById('carId').value = carId;
    modal.style.display = 'block';
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function submitOrder() {
    event.preventDefault();
    var form = document.getElementById('orderForm');
    var data = new FormData(form);

    fetch('', {
        method: 'POST',
        body: data
    })
    .then(response => response.text())
    .then(data => {
        alert('Замовлення створено успішно!');
        modal.style.display = 'none';
        form.reset();
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    var close = document.querySelector('.close-message');
    if (close) {
        close.onclick = function() {
            this.parentElement.style.display = 'none';
        };
    }
});
