@include("admin.layouts.header")
      <div class="container-fluid" style="background-color:#F5F6FA">
         <!--  Row 1 -->
         
         <div class="row">
            <div class="col">
               <div class="d-flex justify-content-between">
                  <h5 class="card-title mb-9 fw-semibold">Orders</h5>
               </div>
               <!-- Start Of Data Table -->
               <div class="table-responsive">
			   		<table class="users-table data-table table table-bordered table-responsive bg-white nowrap">
                        <thead>
                            <tr>
                                <th scope="col">Sn.</th>
                                <th scope="col">Firstname</th>
                                <th scope="col">Lastname</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Reference</th>
                                <th scope="col">Account Name</th>
                                <th scope="col">Account Number</th>
                                <th scope="col">Bank Name</th>
                                <th scope="col">Product Name</th>
								<th scope="col">Product Price</th>
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
<script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/axios/axios.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/js/responsive.bootstrap4.min.js')}}"></script>
<script>
	$('.users-table').DataTable({
        ajax: {
            url: '{{url("/api/orders")}}',
            dataSrc: 'results'
        },
        columns: [
            { data: "id"},
            { data: "user.firstname"},
            { data: "user.lastname"},
            { data: "user.phone"},
			{ data: "amount"},
			{ data: "reference"},
            { data: "account.account_name"},
            { data: "account.account_number"},
            { data: "account.bank_name"},
            { data: "product.name"},
			{ data: "product.price"},
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

