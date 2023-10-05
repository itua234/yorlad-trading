@include("admin.layouts.header")
      <div class="container-fluid" style="background-color:#F5F6FA">
         <!--  Row 1 -->
         
         <div class="row">
            <div class="col">
               <div class="d-flex justify-content-between">
                  <h5 class="card-title mb-9 fw-semibold">Products</h5>
               </div>
               <!-- Start Of Data Table -->
               <div class="table-responsive">
			   		<table class="users-table data-table table table-bordered table-responsive bg-white nowrap">
                        <thead>
                            <tr>
                                <th scope="col">Sn.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Old Price</th>
                                <th scope="col">Returns</th>
                                <th scope="col">Daily Income</th>
                                <th scope="col">Validity Period</th>
								<th scope="col">Expired at</th>
                                <th scope="col">Photo</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
               </div>
               <!-- End Of Data Table -->
               
            </div>
         </div>

      </div>
   </div>
</div>
<script src="{{asset('admin/assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('admin/assets/libs/axios/axios.js')}}"></script>
<script src="{{asset('admin/assets/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/datatables/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/datatables/js/responsive.bootstrap4.min.js')}}"></script>
<script>
	$('.users-table').DataTable({
        ajax: {
            url: '{{url("/api/products")}}',
            dataSrc: 'results'
        },
        columns: [
            { data: "id"},
			{ data: "name"},
			{ data: "price"},
            { data: "old_price"},
            { data: "returns"},
            { data: "daily_income"},
            { data: "validity"},
			{ data: "expired_at"},
            //{ data: "total_withdrawal" }
        ],
		columnDefs: [{
			targets: "datatable-nosort",
			orderable: false,
		}],
		"language": {
			"info": "_START_-_END_ of _TOTAL_ entries",
			searchPlaceholder: "Search",
			paginate: {
				next: '<i class="ion-chevron-right"></i>',
				previous: '<i class="ion-chevron-left"></i>'  
			}
		}
	});
</script>
@include("admin.layouts.footer")

