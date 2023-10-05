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
                                <th scope="col">User</th>
                                <th scope="col">Reference</th>
                                <th scope="col">Account Data</th>
                                <th scope="col">Product Name</th>
								<th scope="col">Product Price</th>
                                <th scope="col">Amount Paid</th>
                                <th scope="col">Status</th>
                                <th scope="col">Edit</th>
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
    const statusClasses = {
        pending: "bg-primary",
        waiting: "bg-primary",
        success: "bg-success",
        failed: "bg-danger"
    };
    let img = "{{asset('admin/assets/images/icons/plane.svg')}}";

    function getAllOrders(){
        $('.users-table').DataTable().destroy();
        $('.users-table').DataTable({
            ajax: {
                url: '{{url("/api/orders")}}',
                dataSrc: 'results'
            },
            columns: [
                { 
                    data: null,
                    render: function(data, type, row){
                        var user = data["user"];
                        return '<div><div>'+user["firstname"]+'</div><div>'+user["lastname"]+'</div><div>'+user["phone"]+'</div></div>'
                    }
                },
                { data: "reference"},
                { 
                    data: null,
                    render: function(data, type, row){
                        var bank = data["account"];
                        return '<div><div>'+bank["account_name"]+'</div><div>'+bank["account_number"]+'</div><div>'+bank["bank_name"]+'</div></div>'
                    }
                },
                { data: "product.name"},
                { data: "product.price"},
                { data: "amount_paid"},
                { 
                    data: null,
                    render: function(data, type, row){
                        var status = data["status"];
                        var date = data["created_at"];
                        return '<div><span class="badge rounded-3 fw-semibold '+statusClasses[status]+'">'+status+'</span></div><div>'+date+'</div>'
                    }
                },
                { 
                    data: null,
                    render: function(data, type, row){
                        if(data.status == "success"){
                            return "confirmed";
                        }else{
                            return '<a class="edit-order trigger-btn" data-id="'+data.id+'"><img src="'+img+'" /></a>'
                        }
                    }   
                },
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
    }
    getAllOrders();

    $(document).on("click", ".edit-order", function(event){
        event.preventDefault();
        let id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm Order!'
        }).then((result) => {
            if (result.isConfirmed) {
                let token = $("meta[name='csrf-token']").attr("content");
                const config = {
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                        "X-Requested-With": "XMLHttpRequest"
                    }
                };
                let url = "<?=url('/dashboard/order/confirm')?>"+"/"+id;
                axios.get(url, config)
                .then((res) => {
                    getAllOrders();
                    Swal.fire(
                        'Confirmed!',
                        'Order has been confirmed.',
                        'success'
                    )
                });
            }
        })
    });
</script>
@include("admin.layouts.footer")

