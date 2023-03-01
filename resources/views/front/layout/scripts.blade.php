<?php 
use App\Models\ProductsFilter; 
$productFilters = ProductsFilter::productFilters();
?>

<script>
  $(document).ready(function() {

    $("#sort").on("change", function() {
        /* this.form.submit(); */
        var sort = $('#sort').val();
        var url = $('#url').val();
        @foreach($productFilters as $filters)
        var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}');
        @endforeach
        $('#grid-anchor').addClass('active');
        $('#list-anchor').removeClass('active');
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'post',
            url: url,
            data: {sort: sort, url: url, @foreach($productFilters as $filters)
                 {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
              @endforeach},
            
            success: function(data) {
                $('.filter_products').html(data);
            },error: function() {
                alert("Error in filter");
            }
        })
    })

    @foreach ($productFilters as $filter)
      $(".{{ $filter['filter_column'] }}").click(function () {
        var url = $('#url').val();
        var sort = $('#sort option:selected').val();

        @foreach ($productFilters as $filters)
          var {{ $filters['filter_column'] }} = get_filter('{{ $filters['filter_column'] }}'); 
        @endforeach

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'post',
            url: url,
            data: {
              @foreach ($productFilters as $filters)
                {{ $filters['filter_column'] }}: {{ $filters['filter_column'] }},
              @endforeach
              url: url, sort: sort 
            },
            
            success: function(data) {
                $('.filter_products').html(data);
            },error: function() {
                alert("Error in filter 2");
            }
        })
      })
    @endforeach

    $('#list-anchor').on('click',function () {
        //alert('Hi!');
        $(this).addClass('active');
        $(this).next().removeClass('active');
        $('.product-container').removeClass('grid-style');
        $('.product-container').addClass('list-style');
    });
    $('#grid-anchor').on('click',function () {
        $(this).addClass('active');
        $(this).prev().removeClass('active');
        $('.product-container').removeClass('list-style');
        $('.product-container').addClass('grid-style');
    });
})
</script>