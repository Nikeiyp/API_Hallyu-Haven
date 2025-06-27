document.addEventListener('DOMContentLoaded', () => {
    const merchList = document.getElementById('merchList');
    const pagination = document.getElementById('pagination');
    const searchInput = document.getElementById('searchInput');
    const productPreview = document.querySelector('#product-preview');

    // ===============================
    // LISTING MERCHANDISE (GRID VIEW)
    // ===============================
    if (merchList && pagination && searchInput) {
        const fetchData = async (page = 1, search = '') => {
            try {
                merchList.innerHTML = '<p class="text-muted">Loading...</p>';
                pagination.innerHTML = '';

                const res = await axios.get(`/api/merchandise?page=${page}&search=${encodeURIComponent(search)}`);
                const data = res.data;

                merchList.innerHTML = '';

                if (!data.data || data.data.length === 0) {
                    merchList.innerHTML = '<p class="text-danger">Tidak ada data ditemukan.</p>';
                    return;
                }

                data.data.forEach(item => {
                    const imageUrl = item.image
                        ? `/storage/${item.image}`
                        : '/asset/images/no-image.jpg';

                    merchList.innerHTML += `
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="${imageUrl}" class="card-img-top" alt="${item.name}">
                                <div class="card-body">
                                    <h5 class="card-title">${item.name}</h5>
                                    <p class="card-text">${item.description ?? '-'}</p>
                                    <p class="text-primary">Rp ${Number(item.price).toLocaleString('id-ID')}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });

                const totalPages = data.last_page || 1;
                const currentPage = data.current_page || 1;
                pagination.innerHTML = '';

                for (let i = 1; i <= totalPages; i++) {
                    pagination.innerHTML += `
                        <li class="page-item ${i === currentPage ? 'active' : ''}">
                            <a class="page-link" href="javascript:void(0);" onclick="fetchData(${i}, '${search}')">${i}</a>
                        </li>
                    `;
                }

            } catch (error) {
                console.error('Error loading merchandise:', error);
                merchList.innerHTML = '<p class="text-danger">Gagal memuat data merchandise.</p>';
                pagination.innerHTML = '';
            }
        };

        window.fetchData = fetchData;

        searchInput.addEventListener('input', () => {
            const query = searchInput.value;
            fetchData(1, query);
        });

        fetchData(); // load awal
    }

    // ===============================
    // HERO SLIDER SECTION
    // ===============================
    if (productPreview) {
        const fetchSliderData = async () => {
            try {
                const token = localStorage.getItem('token');
                const headers = token ? { headers: { Authorization: `Bearer ${token}` } } : {};
                const response = await axios.get('/api/merchandise', headers);
                const data = response.data;

                let sliderContent = '';

                if (Array.isArray(data) && data.length > 0) {
                    data.forEach((item, index) => {
                        const imageUrl = item.image
                            ? `/storage/${item.image}`
                            : `/asset/hallyu-images/slider/slider${index + 1}.png`; // fallback berbeda untuk tiap index

                        sliderContent += `
                            <div class="single-hero-slider-7">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="hero-content-wrap">
                                                <div class="hero-text-7 mt-lg-5">
                                                    <h6 class="mb-20">New Arrival</h6>
                                                    <h1>${item.name}</h1>
                                                    <p>Price: Rp ${Number(item.price).toLocaleString('id-ID')}</p>
                                                    <div class="button-box section-space--mt_60">
                                                        <a href="#" class="text-btn-normal font-weight--reguler font-lg-p">Discover now</a>
                                                    </div>
                                                </div>
                                                <div class="inner-images">
                                                    <div class="image-one">
                                                        <img src="${imageUrl}" width="500" class="img-fluid" alt="${item.name}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    $(productPreview).html(sliderContent);

                    $(productPreview).slick({
                    dots: true,
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    arrows: true,
                    prevArrow: '<span class="arrow-prv"><i class="icon-chevron-left"></i></span>',
                    nextArrow: '<span class="arrow-next"><i class="icon-chevron-right"></i></span>',
                });


                } else {
                    $(productPreview).html(`<p class="text-center text-danger">Tidak ada merchandise tersedia.</p>`);
                }

            } catch (err) {
                console.error('Gagal memuat slider:', err);
                $(productPreview).html(`<p class="text-center text-danger">Gagal memuat data slider.</p>`);
            }
        };

        fetchSliderData();
    }
});
