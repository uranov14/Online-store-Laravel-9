$(document).ready(function() {
    //Call datatable class
    $('#sections').DataTable();
    $('#categories').DataTable();
    $('#brands').DataTable();
    $('#products').DataTable();
    $('#banners').DataTable();
    $('#filters').DataTable();
    $('#coupons').DataTable();
    $('#users').DataTable();
    $('#orders').DataTable();

    //Check Admin Password is correct or not
    $("#current_password").keyup(function() {
        var current_password = $("#current_password").val();
        /* alert(current_password); */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/check-admin-password',
            data: {current_password: current_password},
            success: function(resp) {
                if(!resp) {
                    $("#check_password").html("<font color='red'>Current Password is Incorrect!</font>");
                } else {
                    $("#check_password").html("<font color='green'>Current Password is Correct!</font>");
                }
            },error: function() {
                alert('Error');
            }
        })
    })

    //Update Admin Status
    $(document).on("click", ".updateAdminStatus", function() {
        var status = $(this).children("i").attr("status");
        var admin_id = $(this).attr("admin_id");
        //alert(status); 

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-admin-status',
            data: {status: status, admin_id: admin_id},
            success: function(resp) {
                //alert(resp);
                if (resp['status'] == 0) {
                    $("#admin-"+admin_id).html("<i class='mdi mdi-bookmark-outline' status='Inactive'></i>")
                }else {
                    $("#admin-"+admin_id).html("<i class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },error: function() {
                alert('Error with Admin Status');
            }
        })
    })

    //Update Banner Status
    $(document).on("click", ".updateBannerStatus", function() {
        var status = $(this).children("i").attr("status");
        var banner_id = $(this).attr("banner_id");
        /* alert(banner_id); */

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-banner-status',
            data: {status: status, banner_id: banner_id},
            success: function(resp) {
                /* alert(resp); */
                if (resp['status'] == 0) {
                    $("#banner-"+banner_id).html("<i class='mdi mdi-bookmark-outline' status='Inactive'></i>")
                }else {
                    $("#banner-"+banner_id).html("<i class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },error: function() {
                alert('Error');
            }
        })
    })

    //Update Section Status
    $(document).on("click", ".updateSectionStatus", function() {
        var status = $(this).children("i").attr("status");
        var section_id = $(this).attr("section_id");
        /* alert(section_id); */

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-section-status',
            data: {status: status, section_id: section_id},
            success: function(resp) {
                /* alert(resp); */
                if (resp['status'] == 0) {
                    $("#section-"+section_id).html("<i class='mdi mdi-bookmark-outline' status='Inactive'></i>")
                }else {
                    $("#section-"+section_id).html("<i class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },error: function() {
                alert('Error');
            }
        })
    })

    //Update Category Status
    $(document).on("click", ".updateCategoryStatus", function() {
        var status = $(this).children("i").attr("status");
        var category_id = $(this).attr("category_id");
        /* alert(category_id); */

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-category-status',
            data: {status: status, category_id: category_id},
            success: function(resp) {
                /* alert(resp); */
                if (resp['status'] == 0) {
                    $("#category-"+category_id).html("<i class='mdi mdi-bookmark-outline' status='Inactive'></i>")
                }else {
                    $("#category-"+category_id).html("<i class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },error: function() {
                alert('Error');
            }
        })
    })

    //Update Brand Status
    $(document).on("click", ".updateBrandStatus", function() {
        var status = $(this).children("i").attr("status");
        var brand_id = $(this).attr("brand_id");
        //alert(brand_id);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-brand-status',
            data: {status: status, brand_id: brand_id},
            success: function(resp) {
                //alert(resp);
                if (resp['status'] == 0) {
                    $("#brand-"+brand_id).html("<i class='mdi mdi-bookmark-outline' status='Inactive'></i>")
                }else {
                    $("#brand-"+brand_id).html("<i class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },error: function() {
                alert('Error with status');
            }
        })
    })

    //Update User Status
    $(document).on("click", ".updateUserStatus", function() {
        var status = $(this).children("i").attr("status");
        var user_id = $(this).attr("user_id");
        //alert(user_id);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-user-status',
            data: {status: status, user_id: user_id},
            success: function(resp) {
                //alert(resp);
                if (resp['status'] == 0) {
                    $("#user-"+user_id).html("<i class='mdi mdi-bookmark-outline' status='Inactive'></i>")
                }else {
                    $("#user-"+user_id).html("<i class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },error: function() {
                alert('Error with status');
            }
        })
    })

    //Update Product Status
    $(document).on("click", ".updateProductStatus", function() {
        var status = $(this).children("i").attr("status");
        var product_id = $(this).attr("product_id");
        //alert(status);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-product-status',
            data: {status: status, product_id: product_id},
            success: function(resp) {
                if (resp['status'] == 0) {
                    $("#product-"+product_id).html("<i class='mdi mdi-bookmark-outline' status=0></i>")
                }else {
                    $("#product-"+product_id).html("<i class='mdi mdi-bookmark-check' status=1></i>")
                }
            },error: function() {
                alert('Error with status product');
            }
        })
    })

    //Update Coupon Status
    $(document).on("click", ".updateCouponStatus", function() {
        var status = $(this).children("i").attr("status");
        var coupon_id = $(this).attr("coupon_id");
        //alert(coupon_id);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-coupon-status',
            data: {status: status, coupon_id: coupon_id},
            success: function(resp) {
                if (resp['status'] == 0) {
                    $("#coupon-"+coupon_id).html("<i class='mdi mdi-bookmark-outline' status=0></i>")
                }else {
                    $("#coupon-"+coupon_id).html("<i class='mdi mdi-bookmark-check' status=1></i>")
                }
            },error: function() {
                alert('Error with status coupon');
            }
        })
    })


    //Update Filter Status
    $(document).on("click", ".updateFilterStatus", function() {
        var status = $(this).children("i").attr("status");
        var filter_id = $(this).attr("filter_id");
        //alert(status);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-filter-status',
            data: {status: status, filter_id: filter_id},
            success: function(resp) {
                //alert(resp['status']);
                if (resp['status'] == 0) {
                    $("#filter-"+filter_id).html("<i class='mdi mdi-bookmark-outline' status='Inactive'></i>")
                }else {
                    $("#filter-"+filter_id).html("<i class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },error: function() {
                alert('Error with status filter');
            }
        })
    })

    //Update Filter Values Status
    $(document).on("click", ".updateFilterValueStatus", function() {
        var status = $(this).children("i").attr("status");
        var filter_id = $(this).attr("filter_id");
        //alert(status);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-filter-values-status',
            data: {status: status, filter_id: filter_id},
            success: function(resp) {
                //alert(resp['status']);
                if (resp['status'] == 0) {
                    $("#filter-"+filter_id).html("<i class='mdi mdi-bookmark-outline' status='Inactive'></i>")
                }else {
                    $("#filter-"+filter_id).html("<i class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },error: function() {
                alert('Error with status filter value');
            }
        })
    })

    //Update Attribute Status
    $(document).on("click", ".updateAttributeStatus", function() {
        var status = $(this).children("i").attr("status");
        var attribute_id = $(this).attr("attribute_id");
        //alert(status);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-attribute-status',
            data: {status: status, attribute_id: attribute_id},
            success: function(resp) {
                //alert(resp['status']);
                if (resp['status'] == 0) {
                    $("#attribute-"+attribute_id).html("<i class='mdi mdi-bookmark-outline' status='Inactive'></i>")
                }else {
                    $("#attribute-"+attribute_id).html("<i class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },error: function() {
                alert('Error with status attribute');
            }
        })
    })

    //Update Image Status
    $(document).on("click", ".updateImageStatus", function() {
        var status = $(this).children("i").attr("status");
        var image_id = $(this).attr("image_id");
        //alert(status);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-image-status',
            data: {status: status, image_id: image_id},
            success: function(resp) {
                //alert(resp['status']);
                if (resp['status'] == 0) {
                    $("#image-"+image_id).html("<i class='mdi mdi-bookmark-outline' status='Inactive'></i>")
                }else {
                    $("#image-"+image_id).html("<i class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },error: function() {
                alert('Error with status image');
            }
        })
    })
    
    //Confirm Deletion (Simple Javascript)
    /* $(".confirmDelete").click(function() {
        var title = $(this).attr("title");
        if (confirm("Are you sure to delete this "+title+"?")) {
            return true;
        } else {
            return false;
        }
        //return confirm("Are you sure to delete this "+title+"?");
    }) */

    //Confirm Deletion (Sweetalert Library) 
    $(document).on("click", ".confirmDelete", function() {
        var module = $(this).attr("module");
        var moduleId = $(this).attr("moduleId");
      
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
              //Window delay (Задержка)
              window.location = "/admin/delete-"+module+"/"+moduleId;
            }
          })
    })

    //Append Categories Level
    $("#section_id").change(function () {
        var section_id = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'get',
            url: '/admin/append-categories-level',
            data: {section_id: section_id},
            success: function(resp) {
                //alert(resp);
                $("#appendCategoriesLevel").html(resp);            
            },error: function() {
                alert('Error');
            }
        })
    })

    //Product Attributes Add/Remove Input Fields
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div class="mt-1"><input type="text" name="size[]" class="input-attr"placeholder="Size" />&nbsp;<input type="text" name="sku[]" class="input-attr"placeholder="SKU" />&nbsp;<input type="text" name="price[]" class="input-attr"placeholder="Price" />&nbsp;<input type="text" name="stock[]" class="input-attr"placeholder="Stock" />&nbsp;<a href="javascript:void(0);" class="remove_button"><i class="mdi mdi-table-row-remove"></i></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });

    // Show Filters on selection of Category
    $("#category_id").change(function () {
        var category_id = $(this).val();
        //alert(category_id);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: 'category-filters',
            data: {category_id: category_id},
            success: function(resp) {
                $(".loadFilters").html(resp.view);            
            },error: function() {
                alert('Error with category filters');
            }
        })
    })

    // Show/Hide Coupon Field for Manual/Automatic
    $("#ManualCoupon").click(function () {
        $("#couponField").show();
    })

    $("#AutomaticCoupon").click(function () {
        $("#couponField").hide();
    })
})