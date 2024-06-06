function getBaseURL() {
    var baseURL = window.location.protocol + '//' + window.location.hostname;
    if (window.location.port) {
        baseURL += ':' + window.location.port;
    }
    return baseURL;
}

// Helper function to truncate strings
function truncateString(str, num) {
    if (str.length <= num) {
        return str;
    }
    return str.slice(0, num) + '...';
}

function LoadProducts() {

    var button = $(this);
    var limit = 6; // The number of products to load per request
    var offset = button.data('offset');

    $.ajax({
        url: getBaseURL() + '/api/v1/explore/products',
        type: 'POST',
        data: {
            offset: offset,
            limit: limit
        },
        success: function (response) {
            // Append the new products to the product list
            var products = response.data;

            // we check if there are more products to load and disable the button if not
            if (products.length < limit) {
                button.prop('disabled', true);
                button.html('All Products Loaded');
            }

            $.each(products, function (index, product) {
                var productHtml = '<div class="col">' +
                    '<div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">' +
                    '<div class="card-header border-0 bg-white p-0 mb-3">' +
                    '<div class="d-flex justify-content-between">' +
                    '<div class="d-flex gap-2 align-items-center">' +
                    '<div><img src="' + (product.seller_profile_img || 'default-profile-img-url') + '" alt="#" class="img-fluid rounded-circle"></div>' +
                    '<div class="small fw-bold">' + (product.seller_username || 'Private Account') + '</div>' +
                    '</div>' +
                    '<div><h3 class="badge bg-' + (product.status == 'sold' ? 'danger' : 'success') + '">' + product.status + '</h3></div>' +
                    '</div>' +
                    '</div>' +
                    '<img src="' + product.image + '" class="card-img-top rounded-lg" alt="...">' +
                    '<div class="card-body fw-bold px-0 pb-0">' +
                    '<h5 class="card-title mb-1">' + product.product_name + '</h5>' +
                    '<div class="card-text mb-1"><small class="text-muted">' + truncateString(product.description, 40) + '</small></div>' +
                    '<div class="text-primary"><span class="text-muted">Price :</span> ' + product.price + '$ <span class="text-muted">/ Quantity :</span> ' + product.quantity + '</div>' +
                    '</div>' +
                    '<a href="/products/' + product.product_id + '" class="stretched-link"></a>' +
                    '</div>' +
                    '</div>';
                $('#product-list').append(productHtml);
            });

            // Update the offset
            button.data('offset', offset + limit);
        }
    });

}

function LoadArrivals() {

    var button = $(this);
    var limit = 6; // The number of products to load per request
    var offset = button.data('offset');

    $.ajax({
        url: getBaseURL() + '/api/v1/explore/new-arrivals',
        type: 'POST',
        data: {
            offset: offset,
            limit: limit
        },
        success: function (response) {
            // Append the new products to the product list
            var products = response.data;

            // we check if there are more products to load and disable the button if not
            if (products.length < limit) {
                button.prop('disabled', true);
                button.html('All Arrivals Loaded');
            }

            $.each(products, function (index, product) {
                var productHtml = '<div class="col">' +
                    '<div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">' +
                    '<div class="card-header border-0 bg-white p-0 mb-3">' +
                    '<div class="d-flex justify-content-between">' +
                    '<div class="d-flex gap-2 align-items-center">' +
                    '<div><img src="' + (product.seller_profile_img || 'default-profile-img-url') + '" alt="#" class="img-fluid rounded-circle"></div>' +
                    '<div class="small fw-bold">' + (product.seller_username || 'Private Account') + '</div>' +
                    '</div>' +
                    '<div><h3 class="badge bg-' + (product.status == 'sold' ? 'danger' : 'success') + '">' + product.status + '</h3></div>' +
                    '</div>' +
                    '</div>' +
                    '<img src="' + product.image + '" class="card-img-top rounded-lg" alt="...">' +
                    '<div class="card-body fw-bold px-0 pb-0">' +
                    '<h5 class="card-title mb-1">' + product.product_name + '</h5>' +
                    '<div class="card-text mb-1"><small class="text-muted">' + truncateString(product.description, 40) + '</small></div>' +
                    '<div class="text-primary"><span class="text-muted">Price :</span> ' + product.price + '$ <span class="text-muted">/ Quantity :</span> ' + product.quantity + '</div>' +
                    '</div>' +
                    '<a href="/products/' + product.product_id + '" class="stretched-link"></a>' +
                    '</div>' +
                    '</div>';
                $('#new-arrival-list').append(productHtml);
            });

            // Update the offset
            button.data('offset', offset + limit);
        }
    });

}

function LoadPopulars() {

    var button = $(this);
    var limit = 6; // The number of products to load per request
    var offset = button.data('offset');

    $.ajax({
        url: getBaseURL() + '/api/v1/explore/most-popular',
        type: 'POST',
        data: {
            offset: offset,
            limit: limit
        },
        success: function (response) {
            // Append the new products to the product list
            var products = response.data;

            // we check if there are more products to load and disable the button if not
            if (products.length < limit) {
                button.prop('disabled', true);
                button.html('All Products Loaded');
            }

            $.each(products, function (index, product) {
                var productHtml = '<div class="col">' +
                    '<div class="card osahan-item-list p-3 rounded h-100 shadow-osahan bg-white border-0">' +
                    '<div class="card-header border-0 bg-white p-0 mb-3">' +
                    '<div class="d-flex justify-content-between">' +
                    '<div class="d-flex gap-2 align-items-center">' +
                    '<div><img src="' + (product.seller_profile_img || 'default-profile-img-url') + '" alt="#" class="img-fluid rounded-circle"></div>' +
                    '<div class="small fw-bold">' + (product.seller_username || 'Private Account') + '</div>' +
                    '</div>' +
                    '<div><h3 class="badge bg-' + (product.status == 'sold' ? 'danger' : 'success') + '">' + product.status + '</h3></div>' +
                    '</div>' +
                    '</div>' +
                    '<img src="' + product.image + '" class="card-img-top rounded-lg" alt="...">' +
                    '<div class="card-body fw-bold px-0 pb-0">' +
                    '<h5 class="card-title mb-1">' + product.product_name + '</h5>' +
                    '<div class="card-text mb-1"><small class="text-muted">' + truncateString(product.description, 40) + '</small></div>' +
                    '<div class="text-primary"><span class="text-muted">Price :</span> ' + product.price + '$ <span class="text-muted">/ Quantity :</span> ' + product.quantity + '</div>' +
                    '</div>' +
                    '<a href="/products/' + product.product_id + '" class="stretched-link"></a>' +
                    '</div>' +
                    '</div>';
                $('#most-popular-list').append(productHtml);
            });

            // Update the offset
            button.data('offset', offset + limit);
        }
    });

}

