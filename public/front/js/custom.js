$(document).ready(function() {
    $("#sort").on("change", function() {
        /* this.form.submit(); */
        var sort = $('#sort').val();
        var url = $('#url').val();
        /* $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'post',
            data: {sort: sort, url: url},
            success: function(resp) {
                $('.filter_products').html(resp);
            },error: function() {
                alert('Error in filter_products');
            }
        }) */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'post',
            url: url,
            data: {sort: sort, url: url},
            
            success: function(data) {
                $('.filter_products').html(data);
            },error: function() {
                alert("Error in filter");
            }
        })
    })
})