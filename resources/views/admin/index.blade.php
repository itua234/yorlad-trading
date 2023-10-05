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
                                <th scope="col">User</th>
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
            <!--  End of Row 1 -->
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
            url: '{{url("/api/users")}}',
            dataSrc: 'results'
        },
        columns: [
            { 
                data: null,
                render: function(data, type, row){
                    return '<div><div>'+data["firstname"]+'</div><div>'+data["lastname"]+'</div><div>'+data["phone"]+'</div></div>'
                }
            },
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
		},
        "pageLength": 100,
        "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
	});
</script>
@include("admin.layouts.footer")

