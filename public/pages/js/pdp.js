/**
 * File ini berfungsi untuk mengambil data produk dari API
 * dan menampilkannya di halaman detail produk.
 */

$(function () {
    // URL dasar untuk panggilan API, diambil dari lokasi jendela browser.
    const BASE_URL = window.location.origin;

    // Header standar untuk permintaan API menggunakan Axios.
    const API_HEADERS = {
        headers: {
            Accept: "application/json",
        },
    };

    /**
     * Mengambil ID produk dari URL, melakukan panggilan API,
     * dan mengisi data ke dalam elemen HTML.
     * Menggunakan async/await untuk penanganan asynchronous yang lebih bersih.
     */
    async function displayProductData() {
        try {
            // 1. Ambil ID produk dari segmen terakhir URL.
            const productId = window.location.pathname.split("/").pop();
            if (!productId) {
                throw new Error("ID Produk tidak ditemukan di URL.");
            }
            
            const url = `${BASE_URL}/api/merchandise/${productId}`;

            // 2. Lakukan permintaan GET ke API.
            const response = await axios.get(url, API_HEADERS);
            const product = response.data;

            // 3. Panggil fungsi untuk mengisi data produk ke DOM.
            populateProductDetails(product);

        } catch (error) {
            // 4. Tangani jika terjadi error saat pengambilan data.
            console.error("[ERROR] Gagal mengambil data produk:", error);

            let errorMessage = "Tidak dapat memuat data produk. Silakan coba lagi nanti.";
            if (error.response) {
                errorMessage = `Gagal memuat data (Error: ${error.response.status}).`;
            } else if (error.request) {
                errorMessage = "Tidak ada respons dari server. Periksa koneksi internet Anda.";
            }

            Swal.fire({
                icon: "error",
                title: "Terjadi Kesalahan",
                html: errorMessage,
                confirmButtonText: "OK",
            });
        }
    }

    /**
     * Mengisi detail produk ke elemen-elemen HTML di halaman.
     * @param {object} product - Objek produk dari API.
     */
    function populateProductDetails(product) {
        const { name, price, description, image, brand, publisher, stock, tags } = product;

        // Set gambar produk
        const coverPath = image ? `/storage/${image}` : '/placeholder-image.jpg';
        $(".product-img-main-src, .product-img-main-thumb").attr("src", coverPath);
        // REFACTOR: Menggabungkan pengaturan atribut untuk elemen yang sama.
        $(".product-img-main-href").attr({
            src: coverPath,
            href: coverPath
        });

        // Set detail teks produk
        $("#product-name").text(name || "Nama Produk Tidak Tersedia");
        $("#product-price").text(`IDR ${parseFloat(price || 0).toLocaleString()}`);
        $("#product-description").html(description || "Deskripsi tidak tersedia.");
        $("#product-author").text(brand || "-");
        $("#product-publisher").text(publisher || "-");

        // Set status stok
        const inStock = stock > 0;
        $("#product-status-stock")
            .removeClass("in-stock out-of-stock")
            .addClass(inStock ? "in-stock" : "out-of-stock")
            .html(`<p>Available: <span>${inStock ? "In stock" : "Out of stock"}</span></p>`);

        // REFACTOR: Menggunakan .toggle() untuk menyederhanakan logika show/hide.
        $(".product-add-to-cart").toggle(inStock);
        $(".product-add-to-cart-is-disabled").toggle(!inStock);

        // Set tags produk
        if (tags && tags.length > 0) {
            // REFACTOR: Membuat link tag menjadi fungsional untuk filter/pencarian.
            const tagHtml = tags.split(',')
                                .map(tag => {
                                    const trimmedTag = tag.trim();
                                    const tagUrl = `${BASE_URL}/merchandise?tag=${encodeURIComponent(trimmedTag)}`;
                                    return `<a href="${tagUrl}">${trimmedTag}</a>`;
                                })
                                .join(', ');
            $("#product-tag").html(tagHtml);
        } else {
            $("#product-tag").text("-");
        }

        // Set rating bintang (logika random tetap dipertahankan)
        const reviewStars = randomIntFromInterval(3, 5); // Rating dibuat sedikit lebih realistis
        const starHtml = Array.from({ length: 5 }, (_, i) => 
            `<i class="${i < reviewStars ? "yellow" : ""} icon_star"></i>`
        ).join('');
        $("#product-review-stars").html(starHtml);
        $("#product-review-body-count").text(`${randomIntFromInterval(5, 250)} customer review`);
    }

    /**
     * Menghasilkan angka integer acak dalam rentang tertentu (inklusif).
     */
    function randomIntFromInterval(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    }

    // Panggil fungsi utama saat dokumen siap.
    displayProductData();
});