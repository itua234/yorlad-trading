@include("admin.layouts.header")
      <div class="container-fluid" style="background-color:#F5F6FA">
         <!--  Row 1 -->
         
         <div class="row">
            <div class="col">
               <div class="d-flex justify-content-between">
                  <h5 class="card-title mb-9 fw-semibold">Users</h5>
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
                                <th scope="col">Balance</th>
                                <th scope="col">Referral</th>
                                <th scope="col">Total Income</th>
								<th scope="col">Referral Income</th>
                                <th scope="col">Total Withdrawal</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
               </div>
               <!-- End Of Data Table -->
               
            </div>
         </div>


         <div class="py-6 px-6 text-center">
            <p class="mb-0 fs-4">Design and Developed by <a href="https://adminmart.com/" target="_blank" class="pe-1 text-primary text-decoration-underline">AdminMart.com</a> Distributed by <a href="https://themewagon.com">ThemeWagon</a></p>
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
            url: '{{url("/api/users")}}',
            dataSrc: 'results'
        },
        columns: [
            { data: "id"},
			{ data: "firstname"},
			{ data: "lastname"},
            { data: "phone"},
            { data: "balance"},
            { data: "referral"},
            { data: "total_income"},
			{ data: "referral_income"},
            { data: "total_withdrawal" }
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

