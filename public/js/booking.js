document.addEventListener('DOMContentLoaded', () => {
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const seatInputs = document.querySelectorAll('input[name="seat_count"]');
    const groupInputs = document.querySelectorAll('input[name="seat_group"]');
    const groupCards = document.querySelectorAll('.group-card');
    const bookingForm = document.getElementById('bookingForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');

    function updatePreview() {
        document.getElementById('previewName').textContent = nameInput.value || '-';
        document.getElementById('previewEmail').textContent = emailInput.value || '-';

        const seat = document.querySelector('input[name="seat_count"]:checked');
        document.getElementById('previewSeat').textContent = seat ? seat.value : '-';

        const group = document.querySelector('input[name="seat_group"]:checked');
        const groupCard = group ? group.closest('.group-card') : null;
        const groupName = groupCard ? groupCard.querySelector('.card-title')?.textContent.trim() : '-';
        document.getElementById('previewGroup').textContent = groupName || '-';
    }

    nameInput.addEventListener('input', updatePreview);
    emailInput.addEventListener('input', updatePreview);
    seatInputs.forEach(input => input.addEventListener('change', updatePreview));
    groupInputs.forEach(input => input.addEventListener('change', updatePreview));

    groupCards.forEach(card => {
        card.addEventListener('click', function () {
            groupCards.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            this.querySelector('input[type="radio"]').checked = true;
            updatePreview();
        });
    });

    bookingForm.addEventListener('submit', function () {
        if (submitBtn && submitSpinner && submitText) {
            submitBtn.disabled = true;
            submitSpinner.classList.remove('d-none');
            submitText.textContent = 'Booking Diproses...';
        }
    });
});
