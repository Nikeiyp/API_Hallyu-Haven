

$(function () {

    const BASE_URL = window.location.origin;

    const token = localStorage.getItem('token');

    const API_HEADERS = {
        headers: {
            Accept: "application/json",
            ...(token && { Authorization: `Bearer ${token}` })
        },
    };

    async function displayProductData() {
        try {
            const productId = window.location.pathname.split("/").pop();
            if (!productId) {
                throw new Error("ID Produk tidak ditemukan di URL.");
            }

            const url = `${BASE_URL}/api/merchandise/${productId}`;
            const response = await axios.get(url, API_HEADERS);
            const product = response.data;

            populateProductDetails(product);

        } catch (error) {
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


    function populateProductDetails(product) {
        const { name, price, description, image, brand, publisher, stock, tags } = product;

        const coverPath = image ? `/storage/${image}` : '/placeholder-image.jpg';
        $(".product-img-main-src, .product-img-main-thumb").attr("src", coverPath);
        $(".product-img-main-href").attr({
            src: coverPath,
            href: coverPath
        });

        $("#product-name").text(name || "Nama Produk Tidak Tersedia");
        $("#product-price").text(`IDR ${parseFloat(price || 0).toLocaleString()}`);
        $("#product-description").html(description || "Deskripsi tidak tersedia.");
        $("#product-author").text(brand || "-");
        $("#product-publisher").text(publisher || "-");

        const inStock = stock > 0;
        $("#product-status-stock")
            .removeClass("in-stock out-of-stock")
            .addClass(inStock ? "in-stock" : "out-of-stock")
            .html(`<p>Available: <span>${inStock ? "In stock" : "Out of stock"}</span></p>`);

        $(".product-add-to-cart").toggle(inStock);
        $(".product-add-to-cart-is-disabled").toggle(!inStock);

        if (tags && tags.length > 0) {
            const tagHtml = tags.split(',').map(tag => {
                const trimmedTag = tag.trim();
                const tagUrl = `${BASE_URL}/merchandise?tag=${encodeURIComponent(trimmedTag)}`;
                return `<a href="${tagUrl}">${trimmedTag}</a>`;
            }).join(', ');
            $("#product-tag").html(tagHtml);
        } else {
            $("#product-tag").text("-");
        }

        const reviewStars = randomIntFromInterval(3, 5);
        const starHtml = Array.from({ length: 5 }, (_, i) =>
            `<i class="${i < reviewStars ? "yellow" : ""} icon_star"></i>`
        ).join('');
        $("#product-review-stars").html(starHtml);
        $("#product-review-body-count").text(`${randomIntFromInterval(5, 250)} customer review`);
    }


    function randomIntFromInterval(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    }


    displayProductData();
});
