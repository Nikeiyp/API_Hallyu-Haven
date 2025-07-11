let id_el_list = "#product-list";


function setFilter(el) {
    let $el = $(el);
    let name = $el.attr("name");
    let value = $el.attr("data-value");

    $(`[name="${name}"]`).removeClass("active");
    $el.addClass("active");

    if (!$(`input[name="${name}_hidden"]`).length) {
        $("<input>").attr({
            type: "hidden",
            name: `${name}_hidden`,
            value: value
        }).appendTo("body");
    } else {
        $(`input[name="${name}_hidden"]`).val(value);
    }

    getData(1);
}


function clearPriceFilter() {
    $('input[name="_price_range_hidden"]').remove();
    $('[name="_price_range"]').removeClass("active");
    getData(1);
}


function setTag(tagValue) {
    $('[name="_tags"]').removeClass("active");
    let $el = $(`[name="_tags"][data-value="${tagValue}"]`);
    $el.addClass("active");
    setFilter($el);
}


function clearTagFilter() {
    $('input[name="_tags_hidden"]').remove();
    $('[name="_tags"]').removeClass("active");
    getData(1);
}


function getDataOnEnter(event) {
    if (event.keyCode === 13) {
        getData(1);
    }
}


function getData(toPage = 1) {
    let url = baseUrl.replace(/\/$/, "") + "/api/merchandise";
    $('[name="_page"]').val(toPage);

    let payload = {
        _limit: 8,
        _page: toPage,
    };

    $("._filter").each(function () {
        let name = $(this).attr("name");
        let value = $(this).val();
        if (value && name) {
            payload[name] = value;
        }
    });

    $("input[type='hidden']").each(function () {
        let name = $(this).attr("name").replace('_hidden', '');
        let value = $(this).val();
        if (name && value) {
            payload[name] = value;
        }
    });

    console.log("[PAYLOAD]", payload);

    axios.get(url, {
        params: payload,
        headers: {
            Authorization: `Bearer ${localStorage.getItem('token') || ''}`,
            Accept: "application/json"
        }
    })
    .then(function (response) {
        let template = "";

        response.data.products.forEach((item) => {
            template += `
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="single-product-item text-center">
                    <div class="products-images">
                        <a href="/merchandise/${item.id}" class="product-thumbnail">
                            <img src="/storage/${item.image}" alt="${item.name}" class="product-thumbnail">
                        </a>
                        <div class="product-actions">
                            <a href="/merchandise/${item.id}"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                            <a href="#"><i class="p-icon icon-bag2"></i><span class="tool-tip">Add to cart</span></a>
                        </div>
                    </div>
                    <div class="product-content">
                        <h6 class="product-title"><a href="/merchandise/${item.id}">${item.name}</a></h6>
                        <div class="product-price"><span class="new-price">IDR ${parseFloat(item.price).toLocaleString()}</span></div>
                    </div>
                </div>
            </div>`;
        });

        $(id_el_list).html(template);

        // Pagination
        $("#products_count_start").html(response.data.products_count_start);
        $("#products_count_end").html(response.data.products_count_end);
        $("#products_count_total").html(response.data.products_count_total);

        let currentPage = parseInt(response.data.filter._page);
        let maxPage = Math.ceil(response.data.products_count_total / response.data.filter._limit);

        template = "";

        if (currentPage > 1) {
            template += `<li><a class="prev page-numbers" onclick="getData(1)"><i class="icon-chevron-left"></i> Min Page</a></li>`;
            template += `<li><a class="page-numbers" onclick="getData(${currentPage - 1})">${currentPage - 1}</a></li>`;
        }

        template += `<li><a class="current text-white page-numbers" onclick="getData(${currentPage})">${currentPage}</a></li>`;

        if (currentPage < maxPage) {
            template += `<li><a class="page-numbers" onclick="getData(${currentPage + 1})">${currentPage + 1}</a></li>`;
        }

        if (currentPage + 1 < maxPage) {
            template += `<li><a class="page-numbers" onclick="getData(${currentPage + 2})">${currentPage + 2}</a></li>`;
        }

        if (currentPage < maxPage) {
            template += `<li><a class="next page-numbers" onclick="getData(${maxPage})">Max Page <i class="icon-chevron-right"></i></a></li>`;
        }

        $(id_el_list + "-pagination").html(template);
    })
    .catch(function (error) {
        console.log("[ERROR] response..", error);
        if (error.code === "ERR_BAD_REQUEST") {
            $(id_el_list).html("");
            Swal.fire({
                position: "top-end",
                icon: "warning",
                title: "Waah..",
                html: "Produk-produk yang Anda cari tidak ditemukan",
                showConfirmButton: false,
                timer: 5000,
            });
        } else {
            Swal.fire({
                icon: "error",
                width: 600,
                title: "Error",
                html: error.message,
                confirmButtonText: "Ya",
            });
        }
    });
}

// Panggil saat halaman siap
$(function () {
    getData();
});
