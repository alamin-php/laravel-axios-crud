@extends('layouts.app')
@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop">
                        Add New
                    </button>
                    <h5 class="card-title">Axios CRUD</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Salary</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="employeeTable">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add New Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="add_form">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control form-control-sm" id="name"
                                placeholder="Enter name">
                            <span id="error_n" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control form-control-sm" id="position"
                                placeholder="Enter position">
                            <span id="error_p" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="salary" class="form-label">Salary</label>
                            <input type="number" class="form-control form-control-sm" id="salary"
                                placeholder="Enter salary">
                            <span id="error_s" class="text-danger"></span>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="edit_form">
                        <input type="hidden" id="e_id">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control form-control-sm" id="e_name">
                            <span id="error_n" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control form-control-sm" id="e_position"
                                placeholder="Enter position">
                            <span id="error_p" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="salary" class="form-label">Salary</label>
                            <input type="number" class="form-control form-control-sm" id="e_salary"
                                placeholder="Enter salary">
                            <span id="error_s" class="text-danger"></span>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // table data
            let url = window.location.origin

            function tableData(data) {
                var rows = '';
                var i = 0;
                $.each(data, function(key, value) {
                    value.id
                    rows = rows + '<tr>';
                    rows = rows + '<td>' + ++i + '</td>';
                    rows = rows + '<td>' + value.name + '</td>';
                    rows = rows + '<td>' + value.position + '</td>';
                    rows = rows + '<td>' + value.salary + '</td>';
                    rows = rows + '<td>';
                    rows = rows +
                        '<a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" data-id="' +
                        value.id + '" id="editRow">Edit</a> <a class="btn btn-danger btn-sm" id="deleteRow" data-id="' +
                        value.id + '">Delete</a>';
                    rows = rows + '</td>';
                    rows = rows + '</tr>';
                });
                $("#employeeTable").html(rows);
            }
            // get all data
            function getAllData() {
                axios.get("{{ route('employee.data') }}")
                    .then(response => {
                        tableData(response.data)
                        console.log(response.data)
                    })
                    .catch(error => {

                    })
            }
            getAllData();
            // data store
            $(document).ready(function() {
                $('#add_form').submit(function(e) {
                    e.preventDefault();
                    axios.post("{{ route('employee.store') }}", {
                            name: $('#name').val(),
                            position: $('#position').val(),
                            salary: $('#salary').val()
                        })
                        .then(response => {
                            getAllData();
                            $('#name').val('');
                            $('#position').val('');
                            $('#salary').val('');
                            console.log(response);
                            $('#staticBackdrop').modal('hide');
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Your work has been saved',
                                timer: 2000
                            })
                            $('#error_n').text('');
                            $('#error_p').text('');
                            $('#error_s').text('');
                        })
                        .catch(error => {
                            if (error.response.data.errors.name) {
                                $('#error_n').text(error.response.data.errors.name[0]);
                            }
                            if (error.response.data.errors.position) {
                                $('#error_p').text(error.response.data.errors.position[0]);
                            }
                            if (error.response.data.errors.salary) {
                                $('#error_s').text(error.response.data.errors.salary[0]);
                            }
                        })


                });
                // data delete
                $('body').on('click', '#deleteRow', function(e) {
                    e.preventDefault();
                    let id = $(this).data('id')
                    let del = url + '/employee/destroy/' + id
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
                            axios.get(del)
                                .then(response => {
                                    getAllData();
                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                })
                                .catch(error => {
                                    console.log(error)
                                })
                        }
                    })
                })
                // data edit
                $('body').on('click', '#editRow', function(e) {
                    e.preventDefault();
                    let id = $(this).data('id')
                    let edit = url + '/employee/edit/' + id
                    axios.get(edit)
                        .then(response => {
                            $('#e_id').val(response.data.id);
                            $('#e_name').val(response.data.name);
                            $('#e_position').val(response.data.position);
                            $('#e_salary').val(response.data.salary);
                        })
                        .catch(error => {
                            console.log(error)
                        })
                })
                // data update
                $('body').on('submit', '#edit_form', function(e) {
                    e.preventDefault();
                    let id = $('#e_id').val();
                    let data = {
                        id: id,
                        name: $('#e_name').val(),
                        position: $('#e_position').val(),
                        salary: $('#e_salary').val(),
                    }
                    let path = url + '/employee/update/' + id
                    axios.put(path, data)
                        .then(res => {
                            getAllData();
                            $('#editModal').modal('hide');
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Your work has been saved',
                                timer: 1000
                            })
                            $('#error_n').text('');
                            $('#error_p').text('');
                            $('#error_s').text('');
                        })
                        .catch(error => {
                            console.log(error)
                        })
                })
            });
        </script>
    @endpush
@endsection
