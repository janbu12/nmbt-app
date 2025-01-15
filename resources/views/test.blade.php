<x-app-layout >
    Test
    <x-button @click="fetchData()" id="button">Test Loading</x-button>

    <script>
        function fetchData() {

            Alpine.store('loadingState').showLoading();

            fetch('/test/response', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to send invoice email');
                }
                console.log(response);
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                Alpine.store('loadingState').hideLoading();
            });
        }
    </script>
</x-app-layout>
