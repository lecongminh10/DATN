@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-3">
                        <h1><label for="permission_name" class="form-label">Create New Permission</label></h1>
                    </div>
                    <div class="mb-3">
                        <label for="permission_name" class="form-label">Permission Name</label>
                        <input type="text" class="form-control" id="permission_name" name="permission_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description1" rows="3"></textarea>
                    </div>

                    <div id="permission-values-container">
                        <div class="row mb-3 permission-value-item">
                            <div class="col-md-6">
                                <label for="value" class="form-label">Permission Value</label>
                                <input type="text" class="form-control" name="value[]" required>
                            </div>
                            <div class="col-md-6">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description[]" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Button to add more input fields -->
                    <div class="mb-3">
                        <button type="button" class="btn btn-secondary" id="add-more">Add More</button>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('add-more').addEventListener('click', function() {
            // Template for a new row of permission values
            var newPermissionValue = `
                <div class="row mb-3 permission-value-item">
                    <div class="col-md-6">
                        <label for="value" class="form-label">Permission Value</label>
                        <input type="text" class="form-control" name="value[]">
                    </div>
                    <div class="col-md-6">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description[]" rows="3"></textarea>
                    </div>
                </div>`;

            // Append the new row to the container
            document.getElementById('permission-values-container').insertAdjacentHTML('beforeend',
                newPermissionValue);
        });
    </script>
@endsection
