    <input type="hidden" class="base_url" value="<?= base_url() ?>">
    <script src="<?= base_url("assets/module/jquery/jquery.min.js")?>"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url("assets/module/bootstrap/js/popper.min.js")?>"></script>
    <script src="<?= base_url("assets/module/bootstrap/js/bootstrap.min.js")?>"></script>

    <script src="<?= base_url("assets/module/bootstrap/js/bootstrap.min.js")?>"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?= base_url("assets/module/ps/perfect-scrollbar.jquery.min.js")?>"></script>
    <!--Wave Effects -->
    <script src="<?= base_url("assets/js/waves.js")?>"></script>

    <!--Menu sidebar -->
    <script src="<?= base_url("assets/js/sidebarmenu.js")?>"></script>
    <!--stickey kit -->
    <script src="<?= base_url("assets/module/sticky-kit-master/dist/sticky-kit.min.js")?>"></script>
    <script src="<?= base_url("assets/module/sparkline/jquery.sparkline.min.js")?>"></script>
    <!--Custom JavaScript -->
    <script src="<?= base_url("assets/js/custom.min.js")?>"></script>

    <!-- datatalbe -->
    <script src="<?= base_url("assets/module/datatables.net/js/jquery.dataTables.min.js")?>"></script>
    <script src="<?= base_url("assets/module/datatables.net-bs4/js/dataTables.responsive.min.js")?>"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="<?= base_url("assets/module/styleswitcher/jQuery.style.switcher.js")?>"></script>

    <script>
        $(document).ready(function () {
            var base_url = $('.base_url').val();

            $('#myTable').DataTable();

            var table_raw_materials = $('#raw_Materials').DataTable({
                 "language": { "infoFiltered": "" },
                 "processing": true, //Feature control the processing indicator.
                 "serverSide": true, //Feature control DataTables' server-side processing mode.
                 "responsive": true,
                 "order": [[0,'desc']], //Initial no order.
                 "columns":[
                      {"data": "PK_raw_materials_id","render":function(data, type, row, meta){
                           var str = 'RM-'+row.PK_raw_materials_id;
                           return str;
                           }
                      },
                      {"data":"category_name"},
                      {"data":"material_name"},
                      {"data":"unit"},
                      {"data": "PK_raw_materials_id","render":function(data, type, row, meta){
                           var str = parseFloat(row.average_cost).toFixed(2);
                           return str;
                           }
                      },
                      {"data": "PK_raw_materials_id","render":function(data, type, row, meta){
                           var str = parseFloat(row.sales_price).toFixed(2);
                           return str;
                           }
                      },
                      {"data":"PK_raw_materials_id","render":function(data, type, row, meta){
                           var str = '<button id="edit_Details" class="booking-btn btn btn-warning btn-xs btn-block" data-id="'+row.PK_raw_materials_id+'">Edit</button>';
                               str += '<button id="view_Details" class="booking-btn btn btn-info btn-xs btn-block" data-id="'+row.PK_raw_materials_id+'">View</button>';
                           return str;
                       }
                      },
                 ],
                 "ajax": {
                      "url": base_url+"manageRawMaterials/getRawMaterials",
                      "type": "POST"
                 },
                 "columnDefs": [
                      {
                           "targets": [6],
                           "orderable": false,
                       },
                  ],
            });

            $(document).on('submit','#Raw_Material_Add', function(e) {
                 e.preventDefault();
                 var formData = new FormData($(this)[0]);

                 $.ajax({
                      url         : base_url + 'manageRawMaterials/addRawMaterial',
                      data        : formData,
                      processData : false,
                      contentType : false,
                      cache       : false,
                      type        : 'POST',
                      success     : function(data){
                                    table_raw_materials.ajax.reload();
                                    $('.add_raw_material_modal').modal('hide');
                      }
                 });
            });

            $(document).on('click', '#view_Details', function() {
                var id = $(this).data('id');
                $('.view_details_modal').modal('show');
                $('.view_details_modal input').prop('disabled', true);

                $.ajax({
                     url      :  base_url + 'manageRawMaterials/viewDetails',
                     type     :  "post",
                     data     :  {  "id"  : id  },
                     dataType :  'json',
                     success  :  function(data){
                                  $('.view_details_modal input[name="material_name"]').val(data.material_name);
                                  $('.view_details_modal input[name="category"]').val(data.category_name);
                                  $('.view_details_modal input[name="unit"]').val(data.unit);
                                  $('.view_details_modal input[name="average_cost"]').val(data.average_cost);
                                  $('.view_details_modal input[name="sales_price"]').val(data.sales_price);
                     }
                });
            });

            $(document).on('click', '#edit_Details', function() {
                var id = $(this).data('id');
                $('.edit_details_modal').modal('show');

                $.ajax({
                     url      :  base_url + 'manageRawMaterials/viewDetails',
                     type     :  "post",
                     data     :  {  "id"  : id  },
                     dataType :  'json',
                     success  :  function(data){
                                  $('.edit_details_modal input[name="material_name"]').val(data.material_name);
                                  $('.edit_details_modal select[name="category"]').val(data.FK_category_id).trigger('change');
                                  $('.edit_details_modal input[name="unit"]').val(data.unit);
                                  $('.edit_details_modal input[name="average_cost"]').val(data.average_cost);
                                  $('.edit_details_modal input[name="sales_price"]').val(data.sales_price);
                                  $('.edit_details_modal .edit_Button').attr('data-id', data.PK_raw_materials_id);
                     }
                });
            });

            $(document).on('submit','#Raw_Material_Edit', function(e) {
                 e.preventDefault();
                 var formData = new FormData($(this)[0]);
                 var dataid   = $('.edit_details_modal .edit_Button').data('id');
                 formData.append('id', dataid)

                 $.ajax({
                      url         : base_url + 'manageRawMaterials/updateDetails',
                      data        : formData,
                      processData : false,
                      contentType : false,
                      cache       : false,
                      type        : 'POST',
                      success     : function(data){
                                    table_raw_materials.ajax.reload();
                                    $('.edit_details_modal').modal('hide');
                      }
                 });
            });


            //Suppliers
            var table_suppliers = $('#table_suppliers').DataTable({
                 "language": { "infoFiltered": "" },
                 "processing": true, //Feature control the processing indicator.
                 "serverSide": true, //Feature control DataTables' server-side processing mode.
                 "responsive": true,
                 "order": [[0,'desc']], //Initial no order.
                 "columns":[
                      {"data": "PK_supplier_id","render":function(data, type, row, meta){
                           var str = 'S-'+row.PK_supplier_id;
                           return str;
                           }
                      },
                      {"data":"supplier_name"},
                      {"data":"contact_number"},
                      {"data":"PK_supplier_id","render":function(data, type, row, meta){
                           var str = '<div class="mx-auto"> <button id="edit_Supplier_Details" class="booking-btn btn btn-warning btn-xs" data-id="'+row.PK_supplier_id+'">Edit</button>';
                               str += '<button id="view_Supplier_Details" class="booking-btn btn btn-info btn-xs ml-1" data-id="'+row.PK_supplier_id+'">View</button></div>';
                           return str;
                       }
                      },
                 ],
                 "ajax": {
                      "url": base_url+"manageSuppliers/getSuppliers",
                      "type": "POST"
                 },
                 "columnDefs": [
                      {
                           "targets": [3],
                           "orderable": false,
                       },
                  ],
            });

            $(document).on('submit','#Supplier_Add', function(e) {
                 e.preventDefault();
                 var formData = new FormData($(this)[0]);

                 $.ajax({
                      url         : base_url + 'manageSuppliers/addSupplier',
                      data        : formData,
                      processData : false,
                      contentType : false,
                      cache       : false,
                      type        : 'POST',
                      success     : function(data){
                                    table_suppliers.ajax.reload();
                                    $('.add_supplier_modal').modal('hide');
                      }
                 });
            });

            $(document).on('click', '#view_Supplier_Details', function() {
                var id = $(this).data('id');
                $('.view_supplier_details_modal').modal('show');
                $('.view_supplier_details_modal input').prop('disabled', true);

                $.ajax({
                     url      :  base_url + 'manageSuppliers/viewDetails',
                     type     :  "post",
                     data     :  {  "id"  : id  },
                     dataType :  'json',
                     success  :  function(data){
                                  $('.view_supplier_details_modal input[name="supplier_name"]').val(data.supplier_name);
                                  $('.view_supplier_details_modal input[name="address"]').val(data.address);
                                  $('.view_supplier_details_modal input[name="contact_number"]').val(data.contact_number);
                     }
                });
            });

            $(document).on('click', '#edit_Supplier_Details', function() {
                var id = $(this).data('id');
                $('.edit_supplier_details_modal').modal('show');

                $.ajax({
                     url      :  base_url + 'manageSuppliers/viewDetails',
                     type     :  "post",
                     data     :  {  "id"  : id  },
                     dataType :  'json',
                     success  :  function(data){
                                  $('.edit_supplier_details_modal input[name="supplier_name"]').val(data.supplier_name);
                                  $('.edit_supplier_details_modal input[name="address"]').val(data.address);
                                  $('.edit_supplier_details_modal input[name="contact_number"]').val(data.contact_number);
                                  $('.edit_supplier_details_modal .edit_Button').attr('data-id', data.PK_supplier_id);
                     }
                });
            });

            $(document).on('submit','#Supplier_Edit', function(e) {
                 e.preventDefault();
                 var formData = new FormData($(this)[0]);
                 var dataid   = $('.edit_supplier_details_modal .edit_Button').data('id');
                 formData.append('id', dataid)

                 $.ajax({
                      url         : base_url + 'manageSuppliers/updateDetails',
                      data        : formData,
                      processData : false,
                      contentType : false,
                      cache       : false,
                      type        : 'POST',
                      success     : function(data){
                                    table_suppliers.ajax.reload();
                                    $('.edit_supplier_details_modal').modal('hide');
                      }
                 });
            });

        })
    </script>

</body>

</html>
