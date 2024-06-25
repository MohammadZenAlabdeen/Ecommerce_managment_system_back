import axios from "./../../node_modules/axios/dist/axios";

document.addEventListener('DOMContentLoaded', (event) => {
    const tableBody = document.getElementById('table-body');
    const radios = document.querySelectorAll('input[name="deals"]');

    const populateTable = (deals) => {
        tableBody.innerHTML = '';

        deals.forEach((deal) => {
            const row = `
                <tr>
                    <td>${deal.id}</td>
                    <td>${deal.seller.name}</td>
                    <td>${deal.customer_name}</td>
                    <td>${deal.customer_number}</td>
                    <td>${deal.customer_address}</td>
                    <td>${deal.product.name}</td>
                    <td>${deal.quantity}</td>
                    <td>${deal.product.price}</td>
                    <td>${deal.product.percentage}</td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });
    };

    const fetchDeals = (userId, dealType) => {
        axios.get(`http://127.0.0.1:8000/apidashboard/seller/deals/1`)
            .then(response => {
                const data = response.data;
                console.log(data)
                let deals = [];

                switch (dealType) {
                    case 'done':
                        deals = data.doneDeals;
                        break;
                    case 'waiting':
                        deals = data.waitingDeals;
                        break;
                    case 'denied':
                        deals = data.deniedDeals;
                        break;
                    default:
                        deals = data.doneDeals;
                        break;
                }

                populateTable(deals);
            })
            .catch(error => console.error('Error fetching deals:', error));
    };

    // Extract user ID from URL
    const url = window.location.href;
    const userId = url.split('/').pop();

    // Initial population with 'done' deals
    fetchDeals(userId, 'done');

    // Event listener for radio buttons
    radios.forEach(radio => {
        radio.addEventListener('change', () => {
            fetchDeals(userId, radio.value);
        });
    });
});