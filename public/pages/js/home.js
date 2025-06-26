document.addEventListener('DOMContentLoaded', () => {
    const merchList = document.getElementById('merchList');
    const pagination = document.getElementById('pagination');
    const searchInput = document.getElementById('searchInput');

    const fetchData = async (page = 1, search = '') => {
        try {
            // Encode query search agar aman (spasi, simbol)
            const res = await axios.get(`/api/merchandise?page=${page}&search=${encodeURIComponent(search)}`);
            const data = res.data;

            // Kosongkan kontainer produk
            merchList.innerHTML = '';

            // Render setiap item merchandise
            data.data.forEach(item => {
                merchList.innerHTML += `
                    <div class="card p-4 border rounded shadow hover:shadow-md transition">
                        <h3 class="font-bold text-lg mb-1">${item.name}</h3>
                        <p class="text-gray-600 mb-2">${item.description ?? '-'}</p>
                        <p class="text-pink-600 font-semibold text-sm">Rp${item.price}</p>
                    </div>
                `;
            });

            // Render pagination
            pagination.innerHTML = '';
            const totalPages = data.last_page || 1;

            for (let i = 1; i <= totalPages; i++) {
                pagination.innerHTML += `
                    <button class="px-3 py-1 border rounded bg-white hover:bg-pink-100"
                        onclick="fetchData(${i}, '${search}')">
                        ${i}
                    </button>
                `;
            }

        } catch (error) {
            console.error('Error loading data:', error);
            merchList.innerHTML = '<p class="text-red-600">Error loading data</p>';
            pagination.innerHTML = '';
        }
    };

    // Ekspose ke global agar bisa dipanggil dari tombol pagination
    window.fetchData = fetchData;

    // Trigger pencarian saat input diketik
    searchInput.addEventListener('input', () => {
        const query = searchInput.value;
        fetchData(1, query);
    });

    // Load awal
    fetchData();
});