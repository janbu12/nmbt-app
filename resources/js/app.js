import './bootstrap';
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Swal = Swal;

window.Alpine = Alpine;

Alpine.start();

function formatDate(dateString) {
    const date = new Date(dateString); // Konversi string ke objek Date
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Tambahkan leading zero
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const seconds = String(date.getSeconds()).padStart(2, '0');
    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

window.formatDate = formatDate;

function sendToEmail(userName, pickupDate, returnDate, items, grandtotal, email, orderId) {
    fetch('{{ route("invoice.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                user_name: userName,
                pickup_date: pickupDate,
                return_date: returnDate,
                items: items,
                grandtotal: grandtotal,
                email: email,
                order_id: orderId,
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to send invoice email');
            }
            console.log(response);
        })
}

window.sendToEmail = sendToEmail;
