const id_el_list = "#product-preview";

$(function () {
    const productPreview = document.querySelector(id_el_list);
    if (!productPreview) return;

    const fetchSliderData = async () => {
        try {
            // ... (kode untuk mengambil token dan headers tetap sama) ...
            const token = localStorage.getItem('token');
            const headers = {
                params: {
                    _limit: 3,
                    _page: 1,
                    _is_slider: 1, 
                },
                ...(token && { headers: { Authorization: `Bearer ${token}` } }),
            };

            const url = baseUrl.replace(/\/$/, "") + "/api/slider-merchandise";
            const response = await axios.get(url, headers);
            const data = response.data;

            let sliderContent = "";

            const products = Array.isArray(data.products) ? data.products : [];

            if (products.length > 0) {
                products.forEach((item, index) => {
                    const imageUrl = item.cover
                        ? item.cover
                        : `/asset/hallyu-images/slider/slider${index + 1}.png`; // fallback default
                    
                    // PERBAIKAN: URL produk yang benar
                    const productUrl = `${baseUrl.replace(/\/$/, "")}/merchandise/${item.id}`;

                    sliderContent += `
                        // PERBAIKAN: Atribut onclick dihapus dari div ini
                        <div class="single-hero-slider-7">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="hero-content-wrap">
                                            <div class="hero-text-7 mt-lg-5">
                                                <h6 class="mb-20">New Arrival</h6>
                                                <h1>${item.name || 'No Name'}</h1>
                                                <p>Price: Rp ${Number(item.price || 0).toLocaleString('id-ID')}</p>
                                                <div class="button-box section-space--mt_60">
                                                    <a href="${productUrl}" class="text-btn-normal font-weight--reguler font-lg-p">Discover now</a>
                                                </div>
                                            </div>
                                            <div class="inner-images">
                                                <div class="image-one">
                                                    <img src="${imageUrl}" width="500" class="img-fluid" alt="${item.title || item.name}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                $(id_el_list).html(sliderContent);
                // Inisialisasi Slick slider (kode ini sudah benar)
                $(id_el_list).slick({
                    dots: true,
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    arrows: true,
                    prevArrow: '<span class="arrow-prv"><i class="icon-chevron-left"></i></span>',
                    nextArrow: '<span class="arrow-next"><i class="icon-chevron-right"></i></span>',
                    responsive: [
                        {
                            breakpoint: 1199,
                            settings: {
                                slidesToShow: 1,
                            },
                        },
                    ],
                });

            } else {
                $(id_el_list).html(`<p class="text-center text-danger">Tidak ada merchandise tersedia.</p>`);
            }
        } catch (err) {
            console.error("[ERROR] Gagal memuat merchandise:", err);
            // ... (kode error handling Anda sudah bagus) ...
        }
    };

    fetchSliderData();
});