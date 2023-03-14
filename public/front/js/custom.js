$(document).ready(function() {
    $("#getPrice").change(function() {
        var size = $(this).val();
        var product_id = $(this).attr("product_id");
        //alert(product_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/get-product-price',
            data: {size: size, product_id: product_id},
            success: function(resp) {
                if (resp['discount'] > 0) {
                    //alert(resp['product_price']);
                    $(".getAttributePrice").html(`<div class="price">
                    <h4>`+resp['final_price']+`&nbsp;<span style="font-size: 1rem">&#x20b4;</span></h4>
                </div>
                <div class="original-price">
                    <span>Original Price:</span>
                    <span>`+resp['product_price']+`</span>&nbsp;<span style="font-size: .7rem">&#x20b4;</span>
                </div>`);
                } else {
                    //alert(resp['final_price']);
                    $(".getAttributePrice").html(`<div class="price">
                    <h4>`+resp['final_price']+`&nbsp;&#x20b4;</h4>
                </div>`);
                }
            },error: function() {
                alert('Error with product price by change Available Size');
            }
        })
    })
})

function get_filter(class_name) {
    var filter = [];
    $('.'+class_name+':checked').each(function() {
        filter.push($(this).val());
    });

    return filter;
}
