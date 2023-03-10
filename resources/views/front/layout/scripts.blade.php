<?php 
use App\Models\ProductsFilter; 
$productFilters = ProductsFilter::productFilters();
?>

<script>
  $(document).ready(function() {
    //Sort Filter
    $("#sort").on("change", function() {
        /* this.form.submit(); */
        var sort = $('#sort').val();
        var url = $('#url').val();
        var color = get_filter('color');
        var size = get_filter('size');
        var price = get_filter('price');
        var brand = get_filter('brand');
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
            data: {
              @foreach($productFilters as $filters)
                {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
              @endforeach 
              sort: sort, url: url, size: size, color: color, price: price, brand: brand
            },
            
            success: function(data) {
                $('.filter_products').html(data);
            },error: function() {
                alert("Error in filter");
            }
        })
    })
    
    //Size Filter
    $(".size").click(function() {
      var color = get_filter('color');
      var size = get_filter('size');
      var price = get_filter('price');
      var brand = get_filter('brand');
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
          data: {sort: sort, url: url, size: size, color: color, price: price, brand: brand, 
            @foreach($productFilters as $filters)
              {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
            @endforeach
          },
          
          success: function(data) {
              $('.filter_products').html(data);
          },error: function() {
              alert("Error in filter size");
          }
      })
    })

    //Color Filter
    $(".color").click(function() {
      var color = get_filter('color');
      var size = get_filter('size');
      var price = get_filter('price');
      var brand = get_filter('brand');
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
          data: {sort: sort, url: url, size: size, color: color, price: price, brand: brand,
            @foreach($productFilters as $filters)
              {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
            @endforeach
          },
          
          success: function(data) {
              $('.filter_products').html(data);
          },error: function() {
              alert("Error in filter color");
          }
      })
    })

    //Price Filter
    $(".price").click(function() {
      var color = get_filter('color');
      var size = get_filter('size');
      var price = get_filter('price');
      var brand = get_filter('brand');
      var sort = $('#sort').val();
      var url = $('#url').val();
      //alert(price);
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
          data: {sort: sort, url: url, size: size, color: color, price: price, brand: brand, 
            @foreach($productFilters as $filters)
              {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
            @endforeach
          },
          
          success: function(data) {
              $('.filter_products').html(data);
          },error: function() {
              //alert([data['url']]);
              alert("Error in filter price");
          }
      })
    })

    //Brand Filter
    $(".brand").click(function() {
      var color = get_filter('color');
      var size = get_filter('size');
      var price = get_filter('price');
      var brand = get_filter('brand');
      var sort = $('#sort').val();
      var url = $('#url').val();
      //alert(price);
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
          data: {sort: sort, url: url, size: size, color: color, price: price, brand: brand, 
            @foreach($productFilters as $filters)
              {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
            @endforeach
          },
          
          success: function(data) {
              $('.filter_products').html(data);
          },error: function() {
              //alert([data['url']]);
              alert("Error in filter price");
          }
      })
    })

    //Dynamic Filters
    @foreach ($productFilters as $filter)
      $(".{{ $filter['filter_column'] }}").click(function () {
        var url = $('#url').val();
        var sort = $('#sort option:selected').val();
        var color = get_filter('color');
        var size = get_filter('size');
        var price = get_filter('price');
        var brand = get_filter('brand');
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
              url: url, sort: sort, size: size, color: color, price: price, brand: brand 
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