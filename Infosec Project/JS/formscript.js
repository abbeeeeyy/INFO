document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.getElementById('no_of_tickets');
    selectElement.addEventListener('change', updateSeatSelection);
});

function updateSeatSelection() {
    const container = document.getElementById('seat-selection-container');
    const numTickets = parseInt(document.getElementById('no_of_tickets').value);
    
    if (isNaN(numTickets) || numTickets <= 0) {
        container.innerHTML = ''; // Clear the container if no valid number of tickets is selected
        return;
    }

    container.innerHTML = ''; 
    const numSeats = 11, numRows = 6; 
    let selectedSeats = 0;

    for (let row = 0; row < numRows; row++) {
        const seatRow = document.createElement('div');
        seatRow.className = 'seat-row';

        for (let seat = 1; seat <= numSeats; seat++) {
            const seatButton = document.createElement('button');
            seatButton.textContent = String.fromCharCode(65 + row) + seat;
            seatButton.value = seatButton.textContent;
            seatButton.className = 'seat-button';
            seatButton.onclick = function() {
                if (this.classList.contains('selected')) {
                    this.classList.remove('selected');
                    selectedSeats--;
                } else if (selectedSeats < numTickets) {
                    this.classList.add('selected');
                    selectedSeats++;
                } else {
                    alert('You have already selected ' + numTickets + ' seat(s).');
                }
            };
            seatRow.appendChild(seatButton);
        }
        container.appendChild(seatRow);
    }
}

function resetForm() {
    document.getElementById('no_of_tickets').value = '';
    const seatButtons = document.querySelectorAll('.seat-button');
    seatButtons.forEach(button => button.classList.remove('selected'));
    // Reset any other fields you have in your form here.
}

function showThankYou() {
    alert("You have successfully purchased your ticket. Check your email for your receipt.");
    resetForm();
    window.location.href = "../INDEX.php";
}
