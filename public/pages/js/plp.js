let id_el_list = "#product-list";

function getDataOnEnter(event) {
    if (event.keyCode == 13) {
        getData(1);
    }
}

function getData(toPage = 1) {
    let url = baseUrl.replace(/\/$/, "") + "/api/merchandise";
    if (toPage) {
        $('[name="_page"]').val(toPage);
    }

    let payload = {
        _limit: 8,
        _page: toPage,
    };

    $("._filter").each(function () {
        payload[$(this).attr("name")] = $(this).val();
    });

    axios
        .get(url, { params: payload }, apiHeaders)
        .then(function (response) {
            console.log("[DATA] response..", response.data);
            let template = ``;

            // START-- products
            response.data.products.forEach((item) => {
                template += `
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="single-product-item text-center">
                        <div class="products-images">
                            <a href="/product/${item.id}" class="product-thumbnail">
                                <img src="/storage/${item.image}" alt="${item.name}" class="product-thumbnail">

                            </a>
                            <div class="product-actions">
                                <a href="/product/${item.id}"><i class="p-icon icon-plus"></i><span class="tool-tip">Quick View</span></a>
                                <a href="#"><i class="p-icon icon-bag2"></i><span class="tool-tip">Add to cart</span></a>
                            </div>
                        </div>                          
                        <div class="product-content">
                            <h6 class="product-title">
                                <a href="/product/${item.id}">${item.name}</a>
                            </h6>
                            <div class="product-price">
                                <span class="new-price">IDR ${parseFloat(item.price).toLocaleString()}</span>
                            </div>
                        </div>
                    </div>
                </div>`;
            });
            $(id_el_list).html(template);
            // END-- products

            // START-- pagination
            $("#products_count_start").html(response.data.products_count_search);
            $("#products_count_end").html(response.data.products_count_end);
            $("#products_count_total").html(response.data.products_count_total);

            template = "";
            let currentPage = parseInt(response.data.filter._page);
            let maxPage = Math.ceil(response.data.products_count_total / response.data.filter._limit);

            if (currentPage > 1) {
                template += `
                    <li>
                        <a class="prev page-numbers" onclick="getData(1)">
                            <i class="icon-chevron-left"></i>&nbsp;&nbsp;&nbsp;Min Page
                        </a>
                    </li>
                    <li>
                        <a class="page-numbers" onclick="getData(${currentPage - 1})">
                            ${currentPage - 1}
                        </a>
                    </li>`;
            }

            template += `
                <li>
                    <a class="current text-white page-numbers" onclick="getData(${currentPage})">
                        ${currentPage}
                    </a>
                </li>`;

            if (currentPage < maxPage) {
                template += `
                    <li>
                        <a class="page-numbers" onclick="getData(${currentPage + 1})">
                            ${currentPage + 1}
                        </a>
                    </li>`;
            }

            if (currentPage + 1 < maxPage) {
                template += `
                    <li>
                        <a class="page-numbers" onclick="getData(${currentPage + 2})">
                            ${currentPage + 2}
                        </a>
                    </li>`;
            }

            if (currentPage < maxPage) {
                template += `
                    <li>
                        <a class="next page-numbers" onclick="getData(${maxPage})">
                            Max Page<i class="icon-chevron-right"></i>
                        </a>
                    </li>`;
            }

            $(id_el_list + "-pagination").html(template);
            $('[name="_page"]').val(currentPage);
            // END-- pagination
        })

        .catch(function (error) {
            console.log("[ERROR] response..", error);
            if (error.code == "ERR_BAD_REQUEST") {
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

$(function () {
    getData();
});
